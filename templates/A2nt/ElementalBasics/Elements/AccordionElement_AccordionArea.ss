<% if $ElementFilteredControllers %>
<div id="ElementAccordion{$ID}" class="accordion">
	<% loop $ElementFilteredControllers %>
		<div class="accordion-item">
			<div id="ElementHeader{$ID}" class="accordion-header">
				<button
					data-bs-toggle="collapse"
					data-bs-target="#ElementContent{$ID}"
					aria-expanded="false"
					aria-controls="ElementContent{$ID}"
					class="accordion-button collapsed"
				>$Title</button>
			</div>

			<div
				id="ElementContent{$ID}"
				class="accordion-collapse collapse"
				aria-labelledby="ElementHeader{$ID}"
				data-bs-parent="#ElementAccordion{$Parent.ID}"
			>
				<div class="accordion-body">$Me</div>
			</div>
		</div>
	<% end_loop %>
</div>
<% end_if %>
