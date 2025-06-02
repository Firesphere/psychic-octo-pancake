<div class="">
    <div class="row">
        <h1 class="col-12">$Title</h1>
        <h5>Add your calendar, read-only, to Thunderbird/Outlook/CalDAV/Google calendar:</h5>
        <p>
            <a href="$CalendarLink" class="js-copytext" title="Click to copy">
                <i class="bi bi-clipboard-pulse js-copytext-icon"></i>$CalendarLink</a>
        </p>
        <div class="col-12">
            $Content
        </div>
    </div>
    <div class="row">
        <% loop $Days %>
            <div class="col-xs-12 col-md-6">
                <% include CalendarMonth %>
            </div>
        <% end_loop %>
    </div>
</div>
