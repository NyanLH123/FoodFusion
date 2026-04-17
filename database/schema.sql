CREATE DATABASE IF NOT EXISTS foodfusion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE foodfusion;

CREATE TABLE IF NOT EXISTS users (
  userId INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(100) NOT NULL,
  lastname VARCHAR(100) NOT NULL,
  role TINYINT(1) DEFAULT 0,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  login_attempts TINYINT DEFAULT 0,
  locked_until DATETIME DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recipes (
  recipeId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  cuisine VARCHAR(100),
  dietary VARCHAR(100),
  cookingdifficulty ENUM('Easy','Medium','Hard'),
  instructions LONGTEXT,
  image VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ingredients (
  ingredientId INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  unit VARCHAR(50)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS recipe_ingredients (
  ingredientId INT NOT NULL,
  recipeId INT NOT NULL,
  amount DECIMAL(8,2),
  PRIMARY KEY (ingredientId, recipeId),
  FOREIGN KEY (ingredientId) REFERENCES ingredients(ingredientId) ON DELETE CASCADE,
  FOREIGN KEY (recipeId) REFERENCES recipes(recipeId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cookbook (
  postId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT NOT NULL,
  title VARCHAR(255),
  content TEXT,
  moderation_status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  moderation_note VARCHAR(255) DEFAULT NULL,
  moderated_by INT DEFAULT NULL,
  moderated_at DATETIME DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  totalshare INT DEFAULT 0,
  totalInteraction INT DEFAULT 0,
  totalcomment INT DEFAULT 0,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE,
  FOREIGN KEY (moderated_by) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comments (
  commentId INT AUTO_INCREMENT PRIMARY KEY,
  postId INT NOT NULL,
  userId INT NOT NULL,
  message TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (postId) REFERENCES cookbook(postId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS interactions (
  interactionId INT AUTO_INCREMENT PRIMARY KEY,
  postId INT NOT NULL,
  userId INT NOT NULL,
  recipeId INT,
  type VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_interactions_post_user_type (postId, userId, type),
  FOREIGN KEY (postId) REFERENCES cookbook(postId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE,
  FOREIGN KEY (recipeId) REFERENCES recipes(recipeId) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact (
  messageId INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  subject VARCHAR(255),
  message TEXT,
  type VARCHAR(100),
  status ENUM('new','read','replied') NOT NULL DEFAULT 'new',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact_replies (
  replyId INT AUTO_INCREMENT PRIMARY KEY,
  messageId INT NOT NULL,
  admin_userId INT DEFAULT NULL,
  reply TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (messageId) REFERENCES contact(messageId) ON DELETE CASCADE,
  FOREIGN KEY (admin_userId) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS resources (
  resourceId INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  type ENUM('pdf','video','image','infographic','youtube'),
  description TEXT,
  path VARCHAR(500),
  youtube_url VARCHAR(500) DEFAULT NULL,
  uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS downloads (
  resourceId INT NOT NULL,
  userId INT NOT NULL,
  downloaded TINYINT(1) DEFAULT 1,
  downloaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (resourceId, userId),
  FOREIGN KEY (resourceId) REFERENCES resources(resourceId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admin_activity_logs (
  logId INT AUTO_INCREMENT PRIMARY KEY,
  admin_userId INT NOT NULL,
  action VARCHAR(120) NOT NULL,
  target_table VARCHAR(100) NOT NULL,
  target_id INT DEFAULT NULL,
  details VARCHAR(255) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Admin login seed: admin@foodfusion.local / Admin@123!
INSERT INTO users (firstname, lastname, role, status, email, password, login_attempts, locked_until, created_at) VALUES
('Admin', 'FoodFusion', 1, 'active', 'admin@foodfusion.local', '$2y$10$1CfglmCBApGtFlkHWwaDEOATyZdqjaeYGaSRs5XhgT2YndPK5n/PK', 0, NULL, NOW()),
('Mia', 'Lopez', 0, 'active', 'mia@example.com', '$2y$10$kFKwEc1e5PAAkXqHqLa69eZATHnkNuGTwvRuqVAwcFhw6mUJSpmmy', 0, NULL, NOW()),
('Daniel', 'Cho', 0, 'active', 'daniel@example.com', '$2y$10$kFKwEc1e5PAAkXqHqLa69eZATHnkNuGTwvRuqVAwcFhw6mUJSpmmy', 0, NULL, NOW()),
('Aisha', 'Khan', 0, 'active', 'aisha@example.com', '$2y$10$kFKwEc1e5PAAkXqHqLa69eZATHnkNuGTwvRuqVAwcFhw6mUJSpmmy', 0, NULL, NOW()),
('Ethan', 'Park', 0, 'inactive', 'ethan@example.com', '$2y$10$kFKwEc1e5PAAkXqHqLa69eZATHnkNuGTwvRuqVAwcFhw6mUJSpmmy', 0, NULL, NOW())
ON DUPLICATE KEY UPDATE email = VALUES(email);

INSERT INTO recipes (userId, title, description, cuisine, dietary, cookingdifficulty, instructions, image, created_at) VALUES
(2, 'Lemon Herb Chicken Bowl', 'A bright and fresh protein-packed bowl.', 'Mediterranean', 'High Protein', 'Easy', 'Marinate chicken, grill, and serve with greens.', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1200&q=80', NOW()),
(3, 'Thai Basil Noodles', 'Quick wok noodles with chili and basil.', 'Thai', 'Dairy Free', 'Medium', 'Cook noodles, stir fry aromatics, toss and serve.', 'https://images.unsplash.com/photo-1559314809-0d155014e29e?auto=format&fit=crop&w=1200&q=80', NOW()),
(4, 'Creamy Pumpkin Soup', 'Roasted pumpkin soup with warm spices.', 'International', 'Vegetarian', 'Easy', 'Roast pumpkin, simmer, blend smooth.', 'https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?auto=format&fit=crop&w=1200&q=80', NOW()),
(2, 'Baked Miso Salmon', 'Umami-rich salmon with sesame rice.', 'Japanese', 'High Protein', 'Medium', 'Marinate salmon, bake, plate with rice.', 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=1200&q=80', NOW()),
(5, 'Tuscan White Bean Stew', 'Comforting tomato bean stew with kale.', 'Italian', 'Vegan', 'Easy', 'Saute base, simmer beans, finish with greens.', 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=1200&q=80', NOW());

INSERT INTO ingredients (name, unit) VALUES
('Chicken breast', 'g'),
('Quinoa', 'g'),
('Rice noodles', 'g'),
('Pumpkin', 'g'),
('Salmon fillet', 'g');

INSERT INTO recipe_ingredients (ingredientId, recipeId, amount) VALUES
(1, 1, 300.00),
(2, 1, 180.00),
(3, 2, 220.00),
(4, 3, 450.00),
(5, 4, 320.00)
ON DUPLICATE KEY UPDATE amount = VALUES(amount);

INSERT INTO cookbook (userId, title, content, image, moderation_status, moderation_note, moderated_by, moderated_at, created_at, totalshare, totalInteraction, totalcomment) VALUES
(2, 'My Zero-Waste Sunday Cooking', 'I batch prep vegetables and repurpose leftovers into weekday meals.', 'https://images.unsplash.com/photo-1466637574441-749b8f19452f?auto=format&fit=crop&w=1200&q=80', 'approved', 'Great practical post', 1, NOW(), NOW(), 2, 5, 3),
(3, 'How I Made Kids Love Veggies', 'Colorful plating and sauce stations made dinner fun.', 'https://images.unsplash.com/photo-1484980972926-edee96e0960d?auto=format&fit=crop&w=1200&q=80', 'approved', 'Family-friendly content', 1, NOW(), NOW(), 1, 4, 2),
(4, '15-Minute Lunch Rotation', 'I rotate wraps, bowls, and soups with one weekly prep plan.', 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=1200&q=80', 'pending', NULL, NULL, NULL, NOW(), 0, 0, 0),
(5, 'Low-Energy Weeknight Meals', 'I use one-pan methods and residual oven heat to save energy.', 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=1200&q=80', 'rejected', 'Please add clearer steps and avoid copied text.', 1, NOW(), NOW(), 0, 0, 0),
(2, 'Flavor Boosters I Always Keep', 'Simple sauces and spice mixes transformed my home cooking.', 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=80', 'approved', NULL, 1, NOW(), NOW(), 1, 3, 1);

INSERT INTO comments (postId, userId, message, created_at) VALUES
(1, 3, 'Great method, this saved me time this week.', NOW()),
(1, 4, 'I tried this and reduced food waste a lot.', NOW()),
(2, 2, 'Love this approach for family meals.', NOW()),
(5, 5, 'Super practical tips, thanks for sharing.', NOW()),
(2, 2, 'Energy tips are very useful.', NOW());

INSERT INTO interactions (postId, userId, recipeId, type, created_at) VALUES
(1, 2, 1, 'like', NOW()),
(1, 3, NULL, 'share', NOW()),
(2, 4, 2, 'like', NOW()),
(5, 5, NULL, 'bookmark', NOW()),
(2, 2, 4, 'like', NOW());

INSERT INTO contact (userId, subject, message, type, status, created_at) VALUES
(2, 'Recipe Request', 'Could we get more 20-minute dinner recipes?', 'Recipe Request', 'new', NOW()),
(3, 'Partnership', 'Interested in collaborating on a local food event.', 'Partnership', 'read', NOW()),
(NULL, 'General Enquiry', 'How do I reset my account lock?', 'General', 'replied', NOW()),
(4, 'Feedback', 'The new recipe filter UI is excellent.', 'Feedback', 'new', NOW()),
(5, 'General', 'Can we have more vegan breakfast ideas?', 'General', 'new', NOW());

INSERT INTO resources (title, type, description, path, uploaded_at) VALUES
('Weeknight Meal Prep Guide', 'pdf', 'Printable meal prep planning guide.', 'uploads/pdfs/meal-prep-guide.pdf', NOW()),
('Knife Skills Tutorial', 'video', 'Beginner-friendly chopping techniques.', 'uploads/videos/knife-skills.mp4', NOW()),
('Ingredient Substitution Chart', 'image', 'Quick kitchen substitution reference chart.', 'uploads/images/substitution-chart.png', NOW()),
('Kitchen Energy Saver Infographic', 'infographic', 'Tips for reducing kitchen electricity usage.', 'uploads/pdfs/energy-infographic.pdf', NOW()),
('Sustainable Pantry Checklist', 'pdf', 'Checklist for eco-friendly pantry management.', 'uploads/pdfs/sustainable-pantry.pdf', NOW());

INSERT INTO downloads (resourceId, userId, downloaded, downloaded_at) VALUES
(1, 2, 1, NOW()),
(2, 3, 1, NOW()),
(3, 4, 1, NOW()),
(4, 5, 1, NOW()),
(5, 2, 1, NOW())
ON DUPLICATE KEY UPDATE downloaded = VALUES(downloaded), downloaded_at = VALUES(downloaded_at);

INSERT INTO admin_activity_logs (admin_userId, action, target_table, target_id, details, created_at) VALUES
(1, 'approve', 'cookbook', 1, 'Approved featured community post', NOW()),
(1, 'reject', 'cookbook', 4, 'Requested content revisions', NOW()),
(1, 'unlock', 'users', 5, 'Reset login attempts', NOW()),
(1, 'upload', 'resources', 2, 'Uploaded knife skills tutorial', NOW()),
(1, 'status_update', 'contact', 2, 'Marked partnership message as read', NOW());
