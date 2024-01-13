<div class="">
    <% with $JobApplication %>
        <div class="row">
            <h1 class="col-12">$Role at $Company.Name</h1>
            <div class="col-12 pb-2">
                Application date: $ApplicationDate.Nice()<br/>
                <a href="$Link" target="_blank">Link</a><br/>
            </div>
            <hr class="col-12 pb-1" />
            <% if $StatusUpdates %>
                <div class="col-12 col-md-4">
                    <h3>Status updates</h3>
                    <% loop $StatusUpdates.Filter('Hidden', false) %>
                        <% include Note %>
                    <% end_loop %>
                </div>
            <% end_if %>
            <% if $CoverLetter %>
                <div class="col-12 col-md-4">
                    <h3>Cover letter</h3>
                    $CoverLetter
                </div>
            <% end_if %>
            <% if $Notes.Count %>
                <div class="col-12 col-md-4">
                    <h3>Notes:</h3>
                    <% loop $Notes %>
                        <% include Note %>
                    <% end_loop %>
                </div>
            <% end_if %>
        </div>
            <% if $Interviews.Count %>
                <div class="row d-flex justify-content-between">
                    <h3 class="col-12">Interviews:</h3>
                    <% loop $Interviews %>
                        <div class=" mb-5 col-6">
                        <div class="card">
                            <div class="card-body p-3">
                                <h5 class="card-title">Interview</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Interview
                                    date/time: $DateTime.Nice()</h6>
                                <div class="card-text row">
                                    <% if $Notes %>
                                        <h4>Notes on this interview</h4>
                                        <% loop $Notes %>
                                            <div class="col-6 mb-2">
                                                <% include Note %>
                                            </div>
                                        <% end_loop %>
                                    <% else %>
                                        <div class="col">
                                            <p>No notes.</p>
                                        </div>
                                    <% end_if %>
                                </div>
                            </div>
                        </div>
                        </div>
                    <% end_loop %>
                </div>

            <% end_if %>
        </div>
    <% end_with %>
</div>
