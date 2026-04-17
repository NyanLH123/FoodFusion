USE foodfusion;

-- Optional visual demo content for Recipe Collection, Community Cookbook, and Resources pages.
-- Run after importing database/schema.sql

INSERT INTO recipes (userId, title, description, cuisine, dietary, cookingdifficulty, instructions, image, created_at)
VALUES
((SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 'Smoky Chickpea Flatbread', 'Crispy flatbread topped with smoky chickpeas, yogurt drizzle, and herbs.', 'Middle Eastern', 'Vegetarian', 'Medium', '1. Bake flatbread base.\n2. Saute chickpeas with smoked paprika.\n3. Top and finish with lemon and herbs.', 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=1200&q=80', NOW()),
((SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), 'Coconut Lime Shrimp Rice', 'A bright one-pan shrimp rice with coconut milk and lime zest.', 'Southeast Asian', 'Dairy Free', 'Easy', '1. Cook aromatics.\n2. Simmer rice in coconut milk.\n3. Add shrimp and finish with lime.', 'https://images.unsplash.com/photo-1536305030015-63a3f0f0f09b?auto=format&fit=crop&w=1200&q=80', NOW()),
((SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 'Roasted Cauliflower Tacos', 'Street-style tacos with roasted cauliflower, salsa, and avocado cream.', 'Mexican', 'Vegan', 'Easy', '1. Roast cauliflower with spices.\n2. Warm tortillas.\n3. Assemble with salsa and avocado cream.', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?auto=format&fit=crop&w=1200&q=80', NOW());

INSERT IGNORE INTO ingredients (name, unit)
VALUES
('Chickpeas', 'g'),
('Flatbread', 'piece'),
('Shrimp', 'g'),
('Coconut milk', 'ml'),
('Cauliflower', 'g');

INSERT INTO recipe_ingredients (ingredientId, recipeId, amount)
VALUES
((SELECT ingredientId FROM ingredients WHERE name = 'Chickpeas' AND unit = 'g' LIMIT 1), (SELECT recipeId FROM recipes WHERE title = 'Smoky Chickpea Flatbread' ORDER BY recipeId DESC LIMIT 1), 250.00),
((SELECT ingredientId FROM ingredients WHERE name = 'Flatbread' AND unit = 'piece' LIMIT 1), (SELECT recipeId FROM recipes WHERE title = 'Smoky Chickpea Flatbread' ORDER BY recipeId DESC LIMIT 1), 2.00),
((SELECT ingredientId FROM ingredients WHERE name = 'Shrimp' AND unit = 'g' LIMIT 1), (SELECT recipeId FROM recipes WHERE title = 'Coconut Lime Shrimp Rice' ORDER BY recipeId DESC LIMIT 1), 300.00),
((SELECT ingredientId FROM ingredients WHERE name = 'Coconut milk' AND unit = 'ml' LIMIT 1), (SELECT recipeId FROM recipes WHERE title = 'Coconut Lime Shrimp Rice' ORDER BY recipeId DESC LIMIT 1), 350.00),
((SELECT ingredientId FROM ingredients WHERE name = 'Cauliflower' AND unit = 'g' LIMIT 1), (SELECT recipeId FROM recipes WHERE title = 'Roasted Cauliflower Tacos' ORDER BY recipeId DESC LIMIT 1), 450.00)
ON DUPLICATE KEY UPDATE amount = VALUES(amount);

INSERT INTO cookbook (userId, title, content, moderation_status, created_at, totalshare, totalInteraction, totalcomment)
VALUES
((SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 'Budget Meal Prep for Busy Weekdays', 'I prep two sauces, roast one tray of vegetables, and rotate protein choices so weekday dinners stay fast and flexible.', 'approved', NOW(), 2, 6, 3),
((SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), 'My Family-Friendly Spice Strategy', 'I keep a mild base and add spice toppings at the table. It helps everyone enjoy one meal together.', 'approved', NOW(), 1, 4, 2),
((SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 'How I Use Leftovers Without Boredom', 'I transform roasted vegetables into wraps, bowls, and soup base so leftovers feel new each day.', 'approved', NOW(), 3, 8, 4);

INSERT INTO comments (postId, userId, message, created_at)
VALUES
((SELECT postId FROM cookbook WHERE title = 'Budget Meal Prep for Busy Weekdays' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), 'This approach is practical. Sauce prep changed my weekly routine.', NOW()),
((SELECT postId FROM cookbook WHERE title = 'My Family-Friendly Spice Strategy' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 'Great idea. I now do mild curry base with optional chili oil.', NOW()),
((SELECT postId FROM cookbook WHERE title = 'How I Use Leftovers Without Boredom' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), 'Leftover soup base tip is excellent and easy to apply.', NOW());

INSERT INTO interactions (postId, userId, recipeId, type, created_at)
VALUES
((SELECT postId FROM cookbook WHERE title = 'Budget Meal Prep for Busy Weekdays' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), NULL, 'like', NOW()),
((SELECT postId FROM cookbook WHERE title = 'Budget Meal Prep for Busy Weekdays' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), NULL, 'share', NOW()),
((SELECT postId FROM cookbook WHERE title = 'How I Use Leftovers Without Boredom' ORDER BY postId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), NULL, 'bookmark', NOW());

INSERT INTO resources (title, type, description, path, uploaded_at)
VALUES
('7-Day Seasonal Meal Planner', 'pdf', 'Printable meal planning sheet with grocery organization tips.', 'uploads/pdfs/seasonal-planner.pdf', NOW()),
('Batch Cooking Video Series', 'video', 'Short lessons showing how to cook once and reuse components all week.', 'uploads/videos/batch-cooking-series.mp4', NOW()),
('Kitchen Compost Basics', 'pdf', 'Simple compost setup guide for small homes and apartments.', 'uploads/pdfs/compost-basics.pdf', NOW()),
('Energy-Smart Oven Use Infographic', 'infographic', 'Visual tips for reducing oven and stovetop energy use.', 'uploads/pdfs/oven-energy-smart.pdf', NOW());

INSERT INTO downloads (resourceId, userId, downloaded, downloaded_at)
VALUES
((SELECT resourceId FROM resources WHERE title = '7-Day Seasonal Meal Planner' ORDER BY resourceId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'mia@example.com' LIMIT 1), 1, NOW()),
((SELECT resourceId FROM resources WHERE title = 'Batch Cooking Video Series' ORDER BY resourceId DESC LIMIT 1), (SELECT userId FROM users WHERE email = 'daniel@example.com' LIMIT 1), 1, NOW())
ON DUPLICATE KEY UPDATE downloaded = VALUES(downloaded), downloaded_at = VALUES(downloaded_at);