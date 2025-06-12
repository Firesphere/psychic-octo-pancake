<div class="row">
    <% loop $Applications %>
        <div class="col-sm-12 col-md-4 pb-3 d-flex">
            <div class="card  flex-grow-1">
                <% include ApplicationCardHeader %>
                <% if $StatusUpdates.Filter('Hidden', false).Count %>
                    <% include ApplicationCardStatusUpdates %>
                <% end_if %>
                <% if $Interviews.Count %>
                    <% include ApplicationCardInterviews %>
                <% end_if %>
                <% if $Notes.Count %>
                    <% include ApplicationCardNotes %>
                <% end_if %>
                <% include ApplicationCardTimeline %>
                <% include ApplicationCardFooter %>
            </div>
        </div>
    <% end_loop %>
</div>
