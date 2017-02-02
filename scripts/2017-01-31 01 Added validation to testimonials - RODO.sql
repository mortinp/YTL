ALTER TABLE  `testimonials` ADD  `validation_token` CHAR( 32 ) NOT NULL ,
                            ADD  `validated` BOOLEAN NOT NULL DEFAULT '0';