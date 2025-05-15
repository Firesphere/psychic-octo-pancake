<div class="row">
    <h1 class="col-6">$Title</h1>
    <a class="h4 col-6 text-end" href="#" data-bs-target="#sankey-legend" data-bs-toggle="collapse"><br/>Legend</a>

    <div class="col-12">
        $Content
    </div>
    <div class="collapse col-12" id="sankey-legend">
        <div class="row">
            <% loop $getStatusList.Sort('ID ASC') %>
                <div class="col-4">
                    <div class="row">
                        <div class="col-2 text-end text-xs-start">{$ID}(.x):</div>
                        <div class="col">
                            <span class="text-$ColourStyle" name="$Status">&#9679;</span>&nbsp;<span
                            class="m-0 p-0 text-bg-$ColourStyle">$Status</span>
                        </div>
                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>
    <canvas id="sankeychart"></canvas>
    <canvas id="applicationchart"></canvas>
</div>
