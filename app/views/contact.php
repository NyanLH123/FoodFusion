<?php include 'layouts/header.php'; ?>
<main id="main-content" class="section container two-col">
    <section>
        <header class="page-intro">
            <h1>Contact Us</h1>
            <p class="muted">We’d love to hear from you—feedback, recipe ideas, and support enquiries are welcome.</p>
        </header>

        <form class="form-grid elevated" action="#" method="post">
            <label>Name<input type="text" required></label>
            <label>Email<input type="email" required></label>
            <label>Subject<input type="text" required></label>
            <label>Enquiry
                <select>
                    <option>Feedback</option>
                    <option>Recipe Request</option>
                    <option>Support</option>
                </select>
            </label>
            <label>Message<textarea required></textarea></label>
            <button class="btn btn-accent" type="submit">Send Message</button>
        </form>
    </section>
    <aside class="card elevated">
        <h2>Contact Info</h2>
        <p>Email: hello@foodfusion.example</p>
        <p>Phone: +60 12-345 6789</p>
        <p>Address: 22 Culinary Lane, Kuala Lumpur</p>
        <p>Opening Hours: Mon–Fri, 9:00 AM – 6:00 PM</p>
    </aside>
</main>
<?php include 'layouts/footer.php'; ?>
