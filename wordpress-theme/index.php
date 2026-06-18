<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-6 py-16">
  <?php if ( have_posts() ) : ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php while ( have_posts() ) : the_post(); ?>
      <article class="bg-[#1c1b1b] border border-[#5b4039]/25 rounded-2xl overflow-hidden">
        <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( 'medium_large', [ 'class' => 'w-full aspect-video object-cover' ] ); ?>
        </a>
        <?php endif; ?>
        <div class="p-5">
          <h2 class="font-serif text-xl font-bold text-[#f5ede8] mb-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-[#ff8a65] transition-colors"><?php the_title(); ?></a>
          </h2>
          <p class="text-sm text-[#8a706a]"><?php the_excerpt(); ?></p>
        </div>
      </article>
      <?php endwhile; ?>
    </div>
    <div class="mt-10"><?php the_posts_pagination(); ?></div>
  <?php else : ?>
    <p class="text-[#8a706a]">Nincs megjeleníthető tartalom.</p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
