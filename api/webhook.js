const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);
const { Resend } = require('resend');

const resend = new Resend(process.env.RESEND_API_KEY);

// Vercel serverless: raw body kell a Stripe signature ellenőrzéséhez
module.exports.config = {
  api: {
    bodyParser: false,
  },
};

// Raw body összegyűjtése
function getRawBody(req) {
  return new Promise((resolve, reject) => {
    const chunks = [];
    req.on('data', (chunk) => chunks.push(chunk));
    req.on('end', () => resolve(Buffer.concat(chunks)));
    req.on('error', reject);
  });
}

module.exports = async (req, res) => {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  const sig = req.headers['stripe-signature'];
  const webhookSecret = process.env.STRIPE_WEBHOOK_SECRET;

  let event;
  try {
    const rawBody = await getRawBody(req);
    event = stripe.webhooks.constructEvent(rawBody, sig, webhookSecret);
  } catch (err) {
    console.error('Webhook signature hiba:', err.message);
    return res.status(400).json({ error: `Webhook Error: ${err.message}` });
  }

  if (event.type === 'checkout.session.completed') {
    const session = event.data.object;

    const customerEmail = session.customer_details?.email;
    const customerName = session.customer_details?.name || 'Kedves Vásárló';
    const orderId = session.id.slice(-8).toUpperCase();
    const amountTotal = (session.amount_total / 100).toLocaleString('hu-HU');

    // Szállítási cím formázása
    const addr = session.shipping_details?.address;
    const shippingAddress = addr
      ? `${addr.postal_code} ${addr.city}, ${addr.line1}${addr.line2 ? ', ' + addr.line2 : ''}`
      : 'Nem megadott';

    // Vásárolt tételek lekérése
    let itemsHtml = '';
    let itemsText = '';
    try {
      const lineItems = await stripe.checkout.sessions.listLineItems(session.id, { limit: 20 });
      itemsHtml = lineItems.data.map(item => `
        <tr>
          <td style="padding:8px 0;border-bottom:1px solid #2a2a2a;color:#e0e0e0;">${item.description}</td>
          <td style="padding:8px 0;border-bottom:1px solid #2a2a2a;color:#e0e0e0;text-align:center;">${item.quantity}×</td>
          <td style="padding:8px 0;border-bottom:1px solid #2a2a2a;color:#e0e0e0;text-align:right;">${(item.amount_total / 100).toLocaleString('hu-HU')} Ft</td>
        </tr>`).join('');
      itemsText = lineItems.data.map(i =>
        `  ${i.description} × ${i.quantity}  —  ${(i.amount_total / 100).toLocaleString('hu-HU')} Ft`
      ).join('\n');
    } catch (e) {
      console.error('Line items hiba:', e.message);
    }

    const emailHtml = `
<!DOCTYPE html>
<html lang="hu">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#0f0f0f;font-family:'Helvetica Neue',Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#0f0f0f;padding:40px 20px;">
    <tr><td align="center">
      <table width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%;background:#1a1a1a;border-radius:12px;overflow:hidden;border:1px solid #2a2a2a;">

        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#c0392b 0%,#e74c3c 100%);padding:32px 40px;text-align:center;">
            <p style="margin:0 0 8px;font-size:28px;">🌶️</p>
            <h1 style="margin:0;color:#fff;font-size:22px;font-weight:700;letter-spacing:0.5px;">Chilli Baja</h1>
            <p style="margin:8px 0 0;color:rgba(255,255,255,0.85);font-size:14px;">Rendelés visszaigazolás</p>
          </td>
        </tr>

        <!-- Body -->
        <tr>
          <td style="padding:32px 40px;">
            <p style="margin:0 0 24px;color:#e0e0e0;font-size:16px;">Kedves <strong style="color:#fff;">${customerName}</strong>,</p>
            <p style="margin:0 0 24px;color:#b0b0b0;font-size:15px;line-height:1.6;">
              Köszönjük a rendelésed! Megkaptuk a megrendelésed, és hamarosan feldolgozzuk.
              Értesítünk, amint feladjuk a csomagot.
            </p>

            <!-- Rendelés adatok -->
            <div style="background:#111;border-radius:8px;padding:20px 24px;margin:0 0 24px;">
              <p style="margin:0 0 4px;color:#888;font-size:12px;text-transform:uppercase;letter-spacing:1px;">Rendelés azonosító</p>
              <p style="margin:0;color:#e74c3c;font-size:20px;font-weight:700;letter-spacing:2px;">#${orderId}</p>
            </div>

            <!-- Tételek -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
              <tr>
                <td colspan="3" style="padding:0 0 8px;color:#888;font-size:12px;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #2a2a2a;">Megrendelt termékek</td>
              </tr>
              ${itemsHtml}
              <tr>
                <td colspan="2" style="padding:12px 0 0;color:#fff;font-weight:700;font-size:15px;">Összesen</td>
                <td style="padding:12px 0 0;color:#e74c3c;font-weight:700;font-size:15px;text-align:right;">${amountTotal} Ft</td>
              </tr>
            </table>

            <!-- Szállítás -->
            <div style="background:#111;border-radius:8px;padding:16px 24px;margin:0 0 32px;">
              <p style="margin:0 0 4px;color:#888;font-size:12px;text-transform:uppercase;letter-spacing:1px;">Szállítási cím</p>
              <p style="margin:0;color:#e0e0e0;font-size:14px;">${shippingAddress}</p>
            </div>

            <p style="margin:0;color:#888;font-size:13px;line-height:1.6;">
              Kérdésed van? Írj nekünk:
              <a href="mailto:info@chillibaja.hu" style="color:#e74c3c;text-decoration:none;">info@chillibaja.hu</a>
            </p>
          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="padding:20px 40px;border-top:1px solid #2a2a2a;text-align:center;">
            <p style="margin:0;color:#555;font-size:12px;">🌶️ Chilli Baja · Baja, Magyarország</p>
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</body>
</html>`;

    if (customerEmail) {
      try {
        await resend.emails.send({
          from: 'Chilli Baja <rendeles@chillibaja.hu>',
          to: customerEmail,
          subject: `🌶️ Rendelés visszaigazolás – #${orderId}`,
          html: emailHtml,
          text: `Kedves ${customerName},\n\nKöszönjük a rendelésed! Rendelés azonosítód: #${orderId}\n\nMegrendelt termékek:\n${itemsText}\n\nÖsszesen: ${amountTotal} Ft\n\nSzállítási cím: ${shippingAddress}\n\nKérdéssel fordulj hozzánk: info@chillibaja.hu\n\nÜdvözlettel,\nChilli Baja csapata`,
        });
        console.log(`Email elküldve: ${customerEmail}, rendelés: #${orderId}`);
      } catch (emailErr) {
        console.error('Email küldési hiba:', emailErr.message);
        // Nem dobunk hibát – a fizetés már megtörtént
      }
    }
  }

  res.status(200).json({ received: true });
};
