<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<section class="ff-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <span class="ff-section-label">Our story</span>
        <h1 class="ff-section-title">About FoodFusion</h1>

        <p style="font-size:1.05rem;color:var(--ff-gray-700);line-height:1.8;margin-bottom:1.5rem">
          FoodFusion began as a small project to bring together home cooks, culinary students, and professional chefs — all united by a love of food and the craft behind it.
        </p>
        <p style="color:var(--ff-gray-600);line-height:1.8;margin-bottom:1.5rem">
          We believe great cooking is about curiosity as much as technique. Our platform gives you a growing library of recipes, a community where cooks share stories and tips, and a resource hub packed with guides, lesson plans, and food-science references.
        </p>
        <p style="color:var(--ff-gray-600);line-height:1.8;margin-bottom:3rem">
          Whether you're perfecting a béchamel or exploring street food from another continent, FoodFusion is your kitchen companion.
        </p>

        <!-- Values grid -->
        <div class="row g-4 mb-5">
          <?php
          $values = [
            ['bi-heart',        'Community first', 'Every feature we build starts with how it helps our community learn and connect.'],
            ['bi-book',         'Knowledge shared', 'Recipes, resources, and stories are meant to be passed on, not gatekept.'],
            ['bi-shield-check', 'Trust & quality',  'All content goes through a light editorial review so the standard stays high.'],
          ];
          foreach ($values as [$ic, $title, $body]):
          ?>
            <div class="col-md-4">
              <div style="padding:1.25rem;border:1px solid var(--ff-border);border-radius:var(--ff-radius-md);height:100%">
                <i class="bi <?= $ic ?>" style="font-size:1.4rem;color:var(--ff-accent);display:block;margin-bottom:.75rem"></i>
                <h3 style="font-size:.95rem;margin-bottom:.4rem"><?= $title ?></h3>
                <p style="font-size:.83rem;color:var(--ff-gray-500);margin:0"><?= $body ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- CTA strip -->
        <div style="border-top:1px solid var(--ff-border);padding-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;align-items:center">
          <a class="btn-ff-primary" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/register" style="text-decoration:none">Join for free</a>
          <a class="btn-ff-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/contact/index" style="text-decoration:none">Get in touch</a>
        </div>

      </div>
    </div>
  </div>
</section>
