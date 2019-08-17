ALTER TABLE  `drivers` ADD  `has_classic_car` BOOLEAN NOT NULL DEFAULT  '0' AFTER  `has_modern_car`;
ALTER TABLE `testimonials` ADD `use_as_sample` BOOLEAN NOT NULL DEFAULT  '0' AFTER `featured`;