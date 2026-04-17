<section class="ff-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <span class="ff-section-label">Legal</span>
        <h1 class="ff-section-title">Privacy policy</h1>
        <p style="font-size:.82rem;color:var(--ff-gray-400);margin-bottom:2.5rem">Last updated: January 2025</p>

        <?php
        $sections = [
          ['Information we collect', 'When you register, we collect your name and email address. When you post recipes or cookbook entries, that content is stored alongside your account. We also log basic server access data (IP address, browser, timestamps) for security purposes.'],
          ['How we use your information', 'Your data is used to operate the platform — to display your profile, attribute content to you, and send essential account emails. We do not sell or share your data with third parties for marketing.'],
          ['Cookies', 'We use a single session cookie to keep you logged in. An optional analytics cookie (which you can decline via our cookie banner) helps us understand aggregate traffic. No cross-site tracking cookies are used.'],
          ['Data retention', 'Your account and associated content are retained for as long as your account is active. You may request deletion by contacting us. Anonymised, aggregated data may be retained indefinitely for analytics.'],
          ['Your rights', 'You have the right to access, correct, or delete the personal data we hold about you. To exercise these rights, contact us at hello@foodfusion.com.'],
          ['Security', 'Passwords are stored using bcrypt. All connections are encrypted via HTTPS. We conduct periodic security reviews.'],
          ['Changes to this policy', 'We may update this policy from time to time. We will notify registered users of material changes by email.'],
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
