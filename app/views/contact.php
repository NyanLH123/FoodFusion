<?php include 'layouts/header.php'; ?>

<!-- Contact Us Page (Task 3 - 6 Marks) -->
<main class="contact-page">
    <div class="container">
        <!-- Page Header -->
        <header class="page-header">
            <h1>Contact Us</h1>
            <p>Have questions, recipe requests, or feedback? We'd love to hear from you! Reach out to the FoodFusion team.</p>
        </header>

        <!-- Contact Information Section -->
        <section class="contact-info" aria-label="Contact Information">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <h3>Our Location</h3>
                    <p>123 Culinary Street<br>Food District, FD 12345<br>United Kingdom</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">📧</div>
                    <h3>Email Us</h3>
                    <p>General: info@foodfusion.com<br>Support: support@foodfusion.com<br>Recipes: recipes@foodfusion.com</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">📞</div>
                    <h3>Call Us</h3>
                    <p>Phone: +44 20 1234 5678<br>Hours: Mon-Fri, 9AM-6PM GMT<br>Emergency: +44 20 9876 5432</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">💬</div>
                    <h3>Live Chat</h3>
                    <p>Available during business hours<br>Average response time: 5 minutes<br>Click the chat icon below</p>
                </div>
            </div>
        </section>

        <!-- Contact Form Section (Interactive Form - 6 Marks) -->
        <section class="contact-form-section">
            <h2>Send Us a Message</h2>
            <p class="section-description">Fill out the form below and we'll get back to you within 24-48 hours.</p>

            <form action="contact.php" method="POST" class="contact-form">
                <!-- Task 2: Security - CSRF Token Field -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="fullname">Full Name <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="fullname" 
                            name="fullname" 
                            value="<?php echo htmlspecialchars($_SESSION['user_firstname'] ?? ''); ?> <?php echo htmlspecialchars($_SESSION['user_lastname'] ?? ''); ?>"
                            required 
                            autocomplete="name"
                            aria-required="true"
                            placeholder="John Doe"
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>"
                            required 
                            autocomplete="email"
                            aria-required="true"
                            placeholder="john@example.com"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            autocomplete="tel"
                            placeholder="+44 20 1234 5678"
                        >
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <select id="subject" name="subject" required aria-required="true">
                            <option value="">Select a Subject</option>
                            <option value="general">General Enquiry</option>
                            <option value="recipe">Recipe Request</option>
                            <option value="feedback">Feedback</option>
                            <option value="partnership">Partnership Opportunity</option>
                            <option value="support">Technical Support</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">Message <span class="required">*</span></label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6" 
                        required 
                        aria-required="true"
                        placeholder="Tell us how we can help you..."
                    ></textarea>
                </div>

                <!-- Task 4: Privacy & Cookie Consent -->
                <div class="form-group checkbox-group">
                    <input 
                        type="checkbox" 
                        id="privacy" 
                        name="privacy" 
                        required
                        aria-required="true"
                    >
                    <label for="privacy">
                        I agree to the <a href="privacy.php" target="_blank">Privacy Policy</a> and 
                        <a href="cookies.php" target="_blank">Cookie Policy</a>
                    </label>
                </div>

                <div class="form-group checkbox-group">
                    <input 
                        type="checkbox" 
                        id="newsletter" 
                        name="newsletter"
                    >
                    <label for="newsletter">
                        Subscribe to our newsletter for recipe updates and cooking tips
                    </label>
                </div>

                <button type="submit" name="submit_contact" class="btn-primary">
                    Send Message
                </button>
            </form>
        </section>

        <!-- FAQ Section -->
        <section class="contact-faq" aria-label="Frequently Asked Questions">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-grid">
                <article class="faq-item">
                    <h3>How do I submit a recipe?</h3>
                    <p>Visit our Community Cookbook page and use the "Share Your Creation" form to submit your recipe.</p>
                </article>

                <article class="faq-item">
                    <h3>Can I request a specific recipe?</h3>
                    <p>Yes! Use the contact form above and select "Recipe Request" as your subject.</p>
                </article>

                <article class="faq-item">
                    <h3>How long does it take to respond?</h3>
                    <p>We aim to respond to all enquiries within 24-48 hours during business days.</p>
                </article>

                <article class="faq-item">
                    <h3>Do you offer cooking classes?</h3>
                    <p>Yes! Check our Homepage carousel for upcoming cooking events and workshops.</p>
                </article>
            </div>
        </section>

        <!-- Map Section (Optional Visual) -->
        <section class="contact-map" aria-label="Our Location">
            <h2>Find Us</h2>
            <div class="map-container">
                <img src="assets/images/map-placeholder.jpg" alt="Map showing FoodFusion location in London, UK" class="map-image">
                <p class="map-note">📍 123 Culinary Street, Food District, London, UK</p>
            </div>
        </section>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>