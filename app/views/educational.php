<?php include 'layouts/header.php'; ?>

<!-- Educational Resources Page (Task 3 - 4 Marks) -->
<main class="educational-page">
    <div class="container">
        <!-- Page Header -->
        <header class="page-header">
            <h1>Educational Resources</h1>
            <p>Explore downloadable resources, infographics, and videos on renewable energy topics and sustainable cooking practices.</p>
        </header>

        <!-- Section 1: Downloadable Infographics -->
        <section class="resources-section" aria-label="Educational Infographics">
            <h2>Infographics</h2>
            <p class="section-description">Visual guides on renewable energy and sustainable kitchen practices.</p>
            
            <div class="resource-grid">
                <!-- Infographic 1 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/infographic-solar.jpg" alt="Solar Energy Infographic">
                    </div>
                    <div class="card-content">
                        <h3>Solar Energy in Modern Kitchens</h3>
                        <p>How solar power can reduce your kitchen's carbon footprint.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">4.2 MB</span>
                        </div>
                        <a href="assets/downloads/solar-energy-infographic.pdf" class="btn-download" download>
                            Download Infographic
                        </a>
                    </div>
                </article>

                <!-- Infographic 2 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/infographic-wind.jpg" alt="Wind Energy Infographic">
                    </div>
                    <div class="card-content">
                        <h3>Wind Power for Food Production</h3>
                        <p>Understanding renewable energy in agricultural supply chains.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">3.8 MB</span>
                        </div>
                        <a href="assets/downloads/wind-energy-infographic.pdf" class="btn-download" download>
                            Download Infographic
                        </a>
                    </div>
                </article>

                <!-- Infographic 3 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/infographic-sustainable.jpg" alt="Sustainable Cooking Infographic">
                    </div>
                    <div class="card-content">
                        <h3>Sustainable Cooking Practices</h3>
                        <p>Energy-efficient cooking methods for the eco-conscious chef.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">2.9 MB</span>
                        </div>
                        <a href="assets/downloads/sustainable-cooking-infographic.pdf" class="btn-download" download>
                            Download Infographic
                        </a>
                    </div>
                </article>
            </div>
        </section>

        <!-- Section 2: Educational Videos -->
        <section class="resources-section" aria-label="Educational Videos">
            <h2>Educational Videos</h2>
            <p class="section-description">Learn about renewable energy and its impact on food systems.</p>
            
            <div class="video-grid">
                <!-- Video 1 -->
                <article class="video-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/video-renewable.jpg" alt="Renewable Energy Overview">
                        <button class="play-button" aria-label="Play Renewable Energy Overview">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>Introduction to Renewable Energy</h3>
                        <p>Overview of solar, wind, and hydroelectric power sources.</p>
                        <div class="resource-meta">
                            <span class="duration">12 mins</span>
                            <span class="level">Beginner</span>
                        </div>
                        <a href="educational-video.php?id=1" class="btn-view">Watch Video</a>
                    </div>
                </article>

                <!-- Video 2 -->
                <article class="video-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/video-food-systems.jpg" alt="Food Systems and Energy">
                        <button class="play-button" aria-label="Play Food Systems and Energy">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>Food Systems & Energy Consumption</h3>
                        <p>How energy usage affects food production and distribution.</p>
                        <div class="resource-meta">
                            <span class="duration">18 mins</span>
                            <span class="level">Intermediate</span>
                        </div>
                        <a href="educational-video.php?id=2" class="btn-view">Watch Video</a>
                    </div>
                </article>

                <!-- Video 3 -->
                <article class="video-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/video-green-kitchen.jpg" alt="Green Kitchen Guide">
                        <button class="play-button" aria-label="Play Green Kitchen Guide">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>Building a Green Kitchen</h3>
                        <p>Practical tips for reducing energy consumption at home.</p>
                        <div class="resource-meta">
                            <span class="duration">15 mins</span>
                            <span class="level">Advanced</span>
                        </div>
                        <a href="educational-video.php?id=3" class="btn-view">Watch Video</a>
                    </div>
                </article>
            </div>
        </section>

        <!-- Section 3: Downloadable Resources Library -->
        <section class="resources-section" aria-label="Resource Library">
            <h2>Resource Library</h2>
            <p class="section-description">Comprehensive guides and worksheets on renewable energy topics.</p>
            
            <div class="library-list">
                <!-- Resource 1 -->
                <article class="library-item">
                    <div class="item-icon">📄</div>
                    <div class="item-content">
                        <h3>Renewable Energy Basics Guide</h3>
                        <p>Complete beginner's guide to understanding renewable energy sources.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">5.1 MB</span>
                            <span class="pages">24 Pages</span>
                        </div>
                    </div>
                    <a href="assets/downloads/renewable-energy-guide.pdf" class="btn-download" download>Download</a>
                </article>

                <!-- Resource 2 -->
                <article class="library-item">
                    <div class="item-icon">📊</div>
                    <div class="item-content">
                        <h3>Energy Consumption Worksheet</h3>
                        <p>Track and calculate your kitchen's energy usage with this interactive worksheet.</p>
                        <div class="resource-meta">
                            <span class="file-type">XLSX</span>
                            <span class="file-size">1.2 MB</span>
                            <span class="pages">Interactive</span>
                        </div>
                    </div>
                    <a href="assets/downloads/energy-worksheet.xlsx" class="btn-download" download>Download</a>
                </article>

                <!-- Resource 3 -->
                <article class="library-item">
                    <div class="item-icon">📋</div>
                    <div class="item-content">
                        <h3>Sustainable Living Checklist</h3>
                        <p>Daily habits to reduce your environmental impact in the kitchen.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">0.8 MB</span>
                            <span class="pages">2 Pages</span>
                        </div>
                    </div>
                    <a href="assets/downloads/sustainable-checklist.pdf" class="btn-download" download>Download</a>
                </article>

                <!-- Resource 4 -->
                <article class="library-item">
                    <div class="item-icon">🎓</div>
                    <div class="item-content">
                        <h3>Certification Study Materials</h3>
                        <p>Study guides for renewable energy certification programs.</p>
                        <div class="resource-meta">
                            <span class="file-type">ZIP</span>
                            <span class="file-size">15.3 MB</span>
                            <span class="pages">Multiple Files</span>
                        </div>
                    </div>
                    <a href="assets/downloads/certification-materials.zip" class="btn-download" download>Download</a>
                </article>
            </div>
        </section>

        <!-- Section 4: Topic Categories -->
        <section class="resources-filter" aria-label="Educational Topics">
            <h2>Browse by Topic</h2>
            <div class="category-tags">
                <a href="educational.php?topic=all" class="tag active">All Topics</a>
                <a href="educational.php?topic=solar" class="tag">Solar Energy</a>
                <a href="educational.php?topic=wind" class="tag">Wind Power</a>
                <a href="educational.php?topic=hydro" class="tag">Hydroelectric</a>
                <a href="educational.php?topic=sustainability" class="tag">Sustainability</a>
                <a href="educational.php?topic=efficiency" class="tag">Energy Efficiency</a>
            </div>
        </section>

        <!-- Task 4: Privacy & Cookie Notice -->
        <section class="educational-notice">
            <p>📚 All educational resources are free to download. By accessing these materials, you agree to our <a href="privacy.php">Privacy Policy</a> and <a href="cookies.php">Cookie Policy</a>.</p>
        </section>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>