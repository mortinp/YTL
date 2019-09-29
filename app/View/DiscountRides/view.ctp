<div class="discountRides view">
<h2><?php echo __('Discount Ride'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Driver Id'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['driver_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Origin'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['origin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Destination'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['destination']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hour Min'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['hour_min']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hour Max'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['hour_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Booked'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['is_booked']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($discountRide['DiscountRide']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Discount Ride'), array('action' => 'edit', $discountRide['DiscountRide']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Discount Ride'), array('action' => 'delete', $discountRide['DiscountRide']['id']), null, __('Are you sure you want to delete # %s?', $discountRide['DiscountRide']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Discount Rides'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Discount Ride'), array('action' => 'add')); ?> </li>
	</ul>
</div>
