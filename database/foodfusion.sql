-- FoodFusion Database Schema — matches ER diagram exactly
-- NCC Education | Back End Web Development [2183-1]

CREATE DATABASE IF NOT EXISTS foodfusion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE foodfusion;

-- users: userId, firstname, lastname, role(Boolean=tinyint), email, password
-- login_attempts + locked_until added for Task 2 lockout requirement
CREATE TABLE IF NOT EXISTS users (
  userId         INT AUTO_INCREMENT PRIMARY KEY,
  firstname      VARCHAR(100) NOT NULL,
  lastname       VARCHAR(100) NOT NULL,
  role           TINYINT(1)   NOT NULL DEFAULT 0,
  email          VARCHAR(255) NOT NULL UNIQUE,
  password       VARCHAR(255) NOT NULL,
  login_attempts TINYINT      NOT NULL DEFAULT 0,
  locked_until   DATETIME     DEFAULT NULL
) ENGINE=InnoDB;

-- recipes: recipeId, userId, title, description, cuisine, dietary, cookingdifficulty, instructions, image
CREATE TABLE IF NOT EXISTS recipes (
  recipeId          INT AUTO_INCREMENT PRIMARY KEY,
  userId            INT          NOT NULL,
  title             VARCHAR(255) NOT NULL,
  description       TEXT,
  cuisine           VARCHAR(100),
  dietary           VARCHAR(100),
  cookingdifficulty VARCHAR(50),
  instructions      LONGTEXT,
  image             VARCHAR(255),
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ingredients: ingredientId, name, unit
CREATE TABLE IF NOT EXISTS ingredients (
  ingredientId INT AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(150) NOT NULL,
  unit         VARCHAR(50)
) ENGINE=InnoDB;

-- recipe_ingredients (junction): ingredientId, recipeId, amount(Decimal)
CREATE TABLE IF NOT EXISTS recipe_ingredients (
  ingredientId INT          NOT NULL,
  recipeId     INT          NOT NULL,
  amount       DECIMAL(8,2),
  PRIMARY KEY (ingredientId, recipeId),
  FOREIGN KEY (ingredientId) REFERENCES ingredients(ingredientId) ON DELETE CASCADE,
  FOREIGN KEY (recipeId)     REFERENCES recipes(recipeId)         ON DELETE CASCADE
) ENGINE=InnoDB;

-- cookbook: postId, userId, title, content, createdat, totalshare, totalInteraction, totalcomment
CREATE TABLE IF NOT EXISTS cookbook (
  postId           INT AUTO_INCREMENT PRIMARY KEY,
  userId           INT          NOT NULL,
  title            VARCHAR(255),
  content          TEXT,
  createdat        DATETIME     DEFAULT CURRENT_TIMESTAMP,
  totalshare       INT          NOT NULL DEFAULT 0,
  totalInteraction INT          NOT NULL DEFAULT 0,
  totalcomment     INT          NOT NULL DEFAULT 0,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE CASCADE
) ENGINE=InnoDB;

-- comments: commentId, postId, userId, message, createdat
CREATE TABLE IF NOT EXISTS comments (
  commentId INT AUTO_INCREMENT PRIMARY KEY,
  postId    INT  NOT NULL,
  userId    INT  NOT NULL,
  message   TEXT,
  createdat DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (postId) REFERENCES cookbook(postId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId)    ON DELETE CASCADE
) ENGINE=InnoDB;

-- interactions: interactionId, postId, userId, type, createdat
CREATE TABLE IF NOT EXISTS interactions (
  interactionId INT AUTO_INCREMENT PRIMARY KEY,
  postId        INT         NOT NULL,
  userId        INT         NOT NULL,
  type          VARCHAR(50),
  createdat     DATETIME    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (postId) REFERENCES cookbook(postId) ON DELETE CASCADE,
  FOREIGN KEY (userId) REFERENCES users(userId)    ON DELETE CASCADE
) ENGINE=InnoDB;

-- contact: messageId, userId, subject, message, type, createdat
CREATE TABLE IF NOT EXISTS contact (
  messageId INT AUTO_INCREMENT PRIMARY KEY,
  userId    INT,
  subject   VARCHAR(255),
  message   TEXT,
  type      VARCHAR(100),
  createdat DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE SET NULL
) ENGINE=InnoDB;

-- resources: resourceId, title, type(String), description, path, uploadedat
CREATE TABLE IF NOT EXISTS resources (
  resourceId  INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(255),
  type        VARCHAR(50),
  description TEXT,
  path        VARCHAR(500),
  uploadedat  DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- downloads: resourceId, userId, downloaded(Boolean), downloadat
CREATE TABLE IF NOT EXISTS downloads (
  resourceId INT        NOT NULL,
  userId     INT        NOT NULL,
  downloaded TINYINT(1) NOT NULL DEFAULT 1,
  downloadat DATETIME   DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (resourceId, userId),
  FOREIGN KEY (resourceId) REFERENCES resources(resourceId) ON DELETE CASCADE,
  FOREIGN KEY (userId)     REFERENCES users(userId)         ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── SEED DATA ──────────────────────────────────────────────────────────────
-- Admin password: Admin@123!   hash: password_hash('Admin@123!', PASSWORD_BCRYPT)
-- User  password: User@123!    hash: password_hash('User@123!',  PASSWORD_BCRYPT)

INSERT INTO users (firstname, lastname, role, email, password, login_attempts, locked_until) VALUES
('Admin',  'FoodFusion', 1, 'admin@foodfusion.local', '$2y$10$lgqACJibJyEjaR/wCAwjluOLF2a3Tt4ChuZv9DkN65OWwPjUtKtvW', 0, NULL),
('Mia',    'Lopez',      0, 'mia@example.com',        '$2y$10$m5DHow7CCefiAOm.zCN4/eHdua2kCxLSqLbOLE/afodL92UFXIvyC', 0, NULL),
('Daniel', 'Cho',        0, 'daniel@example.com',     '$2y$10$m5DHow7CCefiAOm.zCN4/eHdua2kCxLSqLbOLE/afodL92UFXIvyC', 0, NULL),
('Aisha',  'Khan',       0, 'aisha@example.com',      '$2y$10$m5DHow7CCefiAOm.zCN4/eHdua2kCxLSqLbOLE/afodL92UFXIvyC', 0, NULL),
('Ethan',  'Park',       0, 'ethan@example.com',      '$2y$10$m5DHow7CCefiAOm.zCN4/eHdua2kCxLSqLbOLE/afodL92UFXIvyC', 0, NULL)
ON DUPLICATE KEY UPDATE email = VALUES(email);

INSERT INTO recipes (userId, title, description, cuisine, dietary, cookingdifficulty, instructions, image) VALUES
(2, 'Lemon Herb Chicken Bowl',
  'Bright, protein-packed bowl with grilled lemon herb chicken over quinoa and seasonal greens.',
  'Mediterranean', 'High Protein', 'Easy',
  'Marinate chicken in lemon, garlic and herbs for 30 min. Grill on medium-high 6 min each side. Serve over cooked quinoa with fresh salad greens.',
  'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1200&q=80'),
(3, 'Thai Basil Noodles',
  'Quick wok noodles with fresh chili, garlic, and Thai basil — weeknight ready in 15 minutes.',
  'Thai', 'Dairy Free', 'Medium',
  'Soften rice noodles in hot water. Heat wok with oil, add garlic and chili. Toss in noodles, sauce and fresh basil. Serve immediately.',
  'https://images.unsplash.com/photo-1559314809-0d155014e29e?auto=format&fit=crop&w=1200&q=80'),
(4, 'Roasted Pumpkin Soup',
  'Silky roasted pumpkin soup with warm spices — a bowl of comfort for cooler evenings.',
  'International', 'Vegetarian', 'Easy',
  'Halve and roast pumpkin at 200C until tender. Scoop flesh, blend with stock, cumin and ginger until smooth. Season and serve hot.',
  'https://images.unsplash.com/photo-1476718406336-bb5a9690ee2a?auto=format&fit=crop&w=1200&q=80'),
(2, 'Baked Miso Salmon',
  'Umami-rich salmon glazed in white miso and honey, served with sesame-dressed rice.',
  'Japanese', 'High Protein', 'Medium',
  'Mix miso, honey, soy and sesame oil. Coat salmon fillets and marinate 1 hour. Bake at 220C for 12 min. Serve over steamed rice.',
  'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=1200&q=80'),
(5, 'Tuscan White Bean Stew',
  'Comforting Italian-style stew with cannellini beans, kale, tomatoes and rosemary.',
  'Italian', 'Vegan', 'Easy',
  'Saute onion, garlic and rosemary. Add chopped tomatoes and simmer 10 min. Add drained beans and kale, cook 15 min. Serve with crusty bread.',
  'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&w=1200&q=80');

INSERT INTO ingredients (name, unit) VALUES
('Chicken breast', 'g'),
('Quinoa',         'g'),
('Rice noodles',   'g'),
('Pumpkin',        'g'),
('Salmon fillet',  'g');

INSERT INTO recipe_ingredients (ingredientId, recipeId, amount) VALUES
(1, 1, 300.00),(2, 1, 180.00),(3, 2, 220.00),(4, 3, 450.00),(5, 4, 320.00)
ON DUPLICATE KEY UPDATE amount = VALUES(amount);

INSERT INTO cookbook (userId, title, content, createdat, totalshare, totalInteraction, totalcomment) VALUES
(2, 'My Zero-Waste Sunday Cooking',
  'Every Sunday I batch prep vegetables and plan three days of meals ahead. The trick is roasting a big tray of whatever is in season, then building wraps, bowls and soups from it all week. Nothing goes to waste and weeknight cooking drops to under 15 minutes.',
  NOW(), 3, 7, 2),
(3, 'How I Made Kids Love Veggies',
  'Colourful plating and a small sauce station on the table transformed dinner. Kids chose their own toppings — suddenly broccoli was exciting. The act of choosing made all the difference.',
  NOW(), 2, 5, 3),
(4, 'My 15-Minute Lunch Rotation',
  'I rotate wraps, grain bowls and quick soups using one Sunday prep session. Cook a batch of lentils, roast two trays of vegetables, keep cooked grains in the fridge. Assembly takes minutes.',
  NOW(), 1, 4, 1),
(5, 'Flavour Boosters I Always Keep',
  'A well-stocked condiment shelf changes everything. My essentials: white miso, fish sauce, smoked paprika, tahini and a good hot sauce. A spoon of one of these rescues a bland dish in seconds.',
  NOW(), 4, 6, 2),
(2, 'Energy-Smart Cooking Tips',
  'I use residual oven heat for softer vegetables after the main roast. Soaking grains in the morning instead of boiling saves 20 minutes. Small habits compounded over a week genuinely add up.',
  NOW(), 2, 3, 1);

INSERT INTO comments (postId, userId, message, createdat) VALUES
(1, 3, 'Batch roasting was a game changer. Saved me so much time this week.',          NOW()),
(1, 4, 'Reduced my food bin by half with this method. Thank you.',                     NOW()),
(2, 2, 'The sauce station idea is genius. My kids are suddenly interested in dinner.',  NOW()),
(4, 5, 'The miso tip alone is worth it. I add it to everything now.',                   NOW()),
(5, 3, 'Never thought about residual oven heat before. Testing this tonight.',          NOW()),
(3, 2, 'Sunday grain prep is exactly what I do. Glad others discovered it too.',        NOW()),
(2, 5, 'Children love autonomy at the table — this really works.',                      NOW());

INSERT INTO interactions (postId, userId, type, createdat) VALUES
(1, 3, 'like',     NOW()),(1, 4, 'like',     NOW()),(2, 2, 'like',  NOW()),
(2, 5, 'bookmark', NOW()),(3, 2, 'like',     NOW()),(4, 3, 'share', NOW()),
(5, 4, 'like',     NOW());

INSERT INTO contact (userId, subject, message, type, createdat) VALUES
(2,    'Recipe Request',  'Could we have more 20-minute dinner recipes for busy weeknights?',             'Recipe Request', NOW()),
(3,    'Partnership',     'We are a local food co-op and would love to collaborate on a seasonal event.', 'Partnership',    NOW()),
(NULL, 'General Enquiry', 'How do I reset my password if my account is locked?',                         'General',        NOW()),
(4,    'Feedback',        'The recipe filter is excellent. Really easy to find vegan options now.',       'Feedback',       NOW()),
(5,    'General',         'Would love to see more vegan breakfast ideas in the collection.',              'General',        NOW());

INSERT INTO resources (title, type, description, path, uploadedat) VALUES
('Weeknight Meal Prep Guide',        'pdf',         'Printable weekly planning guide with shopping list templates.',           'uploads/pdfs/meal-prep-guide.pdf',      NOW()),
('Knife Skills Tutorial',            'video',       'Beginner-friendly tutorial covering chopping, dicing and julienne.',      'uploads/videos/knife-skills.mp4',       NOW()),
('Ingredient Substitution Chart',    'image',       'Quick-reference chart for common ingredient swaps in everyday cooking.',  'uploads/images/substitution-chart.png', NOW()),
('Kitchen Energy Saver Infographic', 'infographic', 'Visual guide to reducing kitchen electricity usage with simple habits.',  'uploads/pdfs/energy-infographic.pdf',   NOW()),
('Sustainable Pantry Checklist',     'pdf',         'Step-by-step checklist for building an eco-friendly, low-waste pantry.',  'uploads/pdfs/sustainable-pantry.pdf',   NOW());

INSERT INTO downloads (resourceId, userId, downloaded, downloadat) VALUES
(1,2,1,NOW()),(2,3,1,NOW()),(3,4,1,NOW()),(4,5,1,NOW()),(5,2,1,NOW())
ON DUPLICATE KEY UPDATE downloaded = 1, downloadat = NOW();
