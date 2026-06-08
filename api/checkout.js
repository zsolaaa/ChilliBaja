const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);

module.exports = async (req, res) => {
  // CORS fejlécek
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Method not allowed' });
  }

  try {
    const { items } = req.body;

    if (!items || items.length === 0) {
      return res.status(400).json({ error: 'Üres kosár' });
    }

    // Stripe line_items létrehozása a kosár tartalmából
    const line_items = items.map(item => ({
      price_data: {
        currency: 'huf',
        product_data: {
          name: item.name,
          description: item.size || undefined,
        },
        unit_amount: Math.round(item.price * 100), // Stripe fillérben számol
      },
      quantity: item.qty,
    }));

    // Szállítási költség hozzáadása ha szükséges
    const subtotal = items.reduce((sum, i) => sum + i.price * i.qty, 0);
    const FREE_SHIP = 20000;
    const SHIP_COST = 2080;

    if (subtotal < FREE_SHIP) {
      line_items.push({
        price_data: {
          currency: 'huf',
          product_data: {
            name: 'Szállítás (GLS)',
            description: subtotal < FREE_SHIP ? `Ingyenes szállítás ${FREE_SHIP.toLocaleString('hu')} Ft felett` : 'Ingyenes szállítás',
          },
          unit_amount: Math.round(SHIP_COST * 100),
        },
        quantity: 1,
      });
    }

    // Stripe Checkout Session létrehozása
    const session = await stripe.checkout.sessions.create({
      payment_method_types: ['card'],
      line_items,
      mode: 'payment',
      success_url: `${req.headers.origin}/success.html`,
      cancel_url: `${req.headers.origin}/webshop.html?canceled=true`,
      locale: 'hu',
      shipping_address_collection: {
        allowed_countries: ['HU'],
      },
      metadata: {
        source: 'chillibaja-webshop',
      },
    });

    res.status(200).json({ url: session.url });

  } catch (error) {
    console.error('Stripe hiba:', error.message);
    res.status(500).json({ error: error.message });
  }
};
