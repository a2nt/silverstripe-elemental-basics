<% if $ElementFilteredControllers %>
<div id="ElementAccordion{$ID}" class="accordion">
	<% loop $ElementFilteredControllers %>
		<div class="accordion-item">
			<div id="ElementHeader{$ID}" class="accordion-header">
				<button
					data-bs-toggle="collapse"
					data-bs-target="#ElementContent{$ID}"
					aria-expanded="<% if $First && $Up.OpenFirst %>true<% else %>false<% end_if %>"
					aria-controls="ElementContent{$ID}"
					class="accordion-button collapsed"
				>$Title</button>
			</div>

			<div
				id="ElementContent{$ID}"
				class="accordion-collapse collapse<% if $First && $Up.OpenFirst %> show<% end_if %>"
				aria-labelledby="ElementHeader{$ID}"
				<% if not $Up.KeepOpenned %>
					data-bs-parent="#ElementAccordion{$Parent.ID}"
				<% end_if %>
			>
				<div class="accordion-body">$Me</div>
			</div>
		</div>
	<% end_loop %>
</div>
<% end_if %>
