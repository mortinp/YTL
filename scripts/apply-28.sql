UPDATE drivers_travels 
SET drivers_travels.user_id = (
	select travels.user_id 
	from travels 
	where travels.id = drivers_travels.travel_id
),
drivers_travels.travel_date = (
	select travels.date 
	from travels 
	where travels.id = drivers_travels.travel_id
);

UPDATE drivers_travels 
SET drivers_travels.original_date = (
	select travels.original_date 
	from travels 
	where travels.id = drivers_travels.travel_id
);