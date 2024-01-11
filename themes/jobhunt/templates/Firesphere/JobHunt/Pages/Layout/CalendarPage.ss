<div class="">
    <div class="row">
        <h1 class="col-12">$Title</h1>
        <div class="col-12">
            $Content
        </div>
    </div>
    <div class="row">
        <% loop $Days %>
            <div class="col-12 col-md-6">
                <div class="calendar">
                    <div class="month">
                        <div class="text-center col">$Month <span class="year">$Year</span></div>
                    </div>
                    <div class="days">
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                    <div class="dates">
                        <% loop $Cal %>
                            <span
                                class="day align-middle
                                <% if $Empty %>empty<% end_if %>
                                    <% if $Today %>today<% end_if %>
                                    <% if $Interviews.Count %>interviews<% end_if %>">
                                <% if not $Empty %>
                                    <time class="time" data-bs-toggle="modal" data-bs-target="#interview_{$Day}">
                                    $Day<% if $Interviews.Count %><sup>$Interviews.Count</sup><% end_if %>
                                </time>
                                    <% if $Interviews.Count %>
                                        <div id="interview_$Day" class="interviews modal modal-lg">
                                    <div class="modal-dialog">
                                            <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Interviews</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="row d-flex justify-content-around">
                                            <% loop $Interviews %>
                                                <div class="card col-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">$Application.Company.Name</h5>
                                                        <h6 class="card-subtitle mb-2 text-muted">Interview at $DateTime.Nice()</h6>
                                                        <% loop $Notes %><p class="card-text">$Note</p><% end_loop %>
                                                        <a href="$Application.Link" class="card-link">$Role</a>
                                                    </div>
                                                </div>
                                                <% if $MultipleOf(3) %></div>
                                                <div class="row d-flex justify-content-around"><% end_if %>
                                            <% end_loop %>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                    <% end_if %>
                                <% end_if %>

                            </span>
                        <% end_loop %>

                    </div>
                </div>
            </div>
        <% end_loop %>
    </div>
</div>
