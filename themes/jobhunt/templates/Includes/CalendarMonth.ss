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
            <% include CalendarDay %>
        <% end_loop %>

    </div>
</div>
