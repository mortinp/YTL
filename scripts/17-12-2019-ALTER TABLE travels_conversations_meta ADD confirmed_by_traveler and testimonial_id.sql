ALTER TABLE `travels_conversations_meta` ADD `confirmed_by_traveler` BOOLEAN NOT NULL AFTER `testimonial_id`, ADD `date_confirmed` DATE NULL AFTER `confirmed_by_traveler`;