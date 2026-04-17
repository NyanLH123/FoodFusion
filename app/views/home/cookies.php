<section class="ff-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="ff-section-label">Legal</span>
        <h1 class="ff-section-title">Cookie policy</h1>
        <p style="font-size:.82rem;color:var(--ff-gray-400);margin-bottom:2.5rem">Last updated: January 2025</p>

        <?php
        $sections = [
          ['What are cookies?', 'Cookies are small text files placed on your device by websites you visit. They are widely used to make websites work, or work more efficiently, and to provide information to the site owners.'],
          ['Essential cookies', 'We use one essential cookie — a PHP session cookie — to keep you signed in during your visit. This cookie expires when you close your browser or after 30 days of inactivity. It cannot be disabled without breaking authentication.'],
          ['Analytics cookies (optional)', 'If you accept analytics cookies, we store a cookie that helps us understand how visitors use FoodFusion in aggregate (pages visited, session length). No personally identifiable data leaves your browser. You can opt out at any time via the banner or by clearing your cookies.'],
          ['Third-party cookies', 'We do not embed third-party advertising or social tracking scripts. Bootstrap CSS and Bootstrap Icons are loaded from a CDN; those requests may set their own performance cookies subject to their own policies.'],
          ['Managing cookies', 'You can control or delete cookies through your browser settings. Deleting cookies will sign you out of FoodFusion. For more information about managing cookies, visit allaboutcookies.org.'],
          ['Changes to this policy', 'We may update this cookie policy when we change how we use cookies. The date at the top of this page reflects the latest revision.'],
        ];
        foreach ($sections as [$title, $body]):
        ?>
          <div style="margin-bottom:2rem">
            <h2 style="font-size:1rem;margin-bottom:.5rem"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h2>
            <p style="color:var(--ff-gray-600);line-height:1.8;margin:0"><?= htmlspecialchars($body, ENT_QUOTES, 'UTF-8') ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
