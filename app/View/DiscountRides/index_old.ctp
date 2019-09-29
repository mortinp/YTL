<div class="discountRides index">
	<h2><?php echo __('Discount Rides'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('driver_id'); ?></th>
			<th><?php echo $this->Paginator->sort('origin'); ?></th>
			<th><?php echo $this->Paginator->sort('destination'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('hour_min'); ?></th>
			<th><?php echo $this->Paginator->sort('hour_max'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('is_booked'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($discountRides as $discountRide): ?>
	<tr>
		<td><?php echo h($discountRide['DiscountRide']['id']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['driver_id']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['origin']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['destination']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['date']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['hour_min']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['hour_max']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['price']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['is_booked']); ?>&nbsp;</td>
		<td><?php echo h($discountRide['DiscountRide']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $discountRide['DiscountRide']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $discountRide['DiscountRide']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $discountRide['DiscountRide']['id']), null, __('Are you sure you want to delete # %s?', $discountRide['DiscountRide']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Discount Ride'), array('action' => 'add')); ?></li>
	</ul>
</div>
