<?php get_header(); ?>

<main class="max-w-4xl mx-auto px-6 py-16">
  <?php while ( have_posts() ) : the_post(); ?>
  <article>
    <h1 class="font-serif text-3xl md:text-4xl font-bold text-[#f5ede8] mb-8"><?php the_title(); ?></h1>
    <div class="prose prose-invert max-w-none text-[#8a706a] leading-relaxed">
      <?php the_content(); ?>
    </div>
  </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
