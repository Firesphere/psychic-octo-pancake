<section class="$Type projects-section bg-light py-3" id="e$ID">
    <main class="py-3 container">
        <div class="row gx-0 mb-4 mb-lg-5 align-items-start">
            <div class="featured-text<% if $Alternate %>-inverse<% end_if %> text-lg-left">
                <% if $ShowTitle %>
                    <h4>$Title</h4>
                <% end_if %>
                <div class="text-black-50 mb-0 row">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="col-2">Colour</th>
                            <th class="col-2">Status</th>
                            <th class="col-6">Description</th>
                            <th class="col-2">Auto-hidden</th>
                        </tr>
                        </thead>
                        <tbody>
                        <% loop $Statusses %>
                            <tr>
                                <td class="p-1 ">$Status</td>
                                <td class="p-1 text-bg-$ColourStyle">$ColourStyle</td>
                                <td class="p-1 ">$Description</td>
                                <td class="p-1 ">$AutoHide.Nice</td>
                            </tr>
                        <% end_loop %>
                        </tbody>
                    </table>
                    <% if $HTML %>
                        <div class="col-12">
                            $HTML
                        </div>
                    <% end_if %>
                </div>
            </div>
        </div>
    </main>
</section>
