update drivers set created =  (

select min(travels.created) 

from drivers_travels

inner join travels on travels.id = drivers_travels.travel_id 

where drivers_travels.driver_id = drivers.id
)