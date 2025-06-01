<section class="projects-section bg-light" id="e$ID">
    <div class="px-4 px-lg-5">
        <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col-12">
                <% if $ShowTitle %>
                    <h3>$Title</h3>
                <% end_if %>
            </div>
            <div class="col-md-{$Width1}">
                <div class="featured-text-inverse text-$Content1Align">
                    <div class="text-black-50 mb-0">
                        $Content1
                    </div>
                </div>
            </div>
            <div class="col-md-{$Width2}">
                <div class="featured-text text-$Content2Align">
                    <div class="text-black-50 mb-0">
                        $Content2
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>