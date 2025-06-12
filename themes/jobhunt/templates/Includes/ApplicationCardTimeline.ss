<div class="card-body d-flex flex-column">
    <div class="progress mt-auto">
        <% loop $TimeLine %>
            <div class="progress-bar shadow-lg progress-bar-striped bg-$Colour border"
                 title="$Status: Started: $StartDay; Ended: $EndDay"
                 role="progressbar"
                 style="width: $Size%"
                 aria-valuenow="$End"
                 aria-valuemin="$Start"
                 aria-valuemax="$End"
            ></div>
        <% end_loop %>
    </div>
</div>
