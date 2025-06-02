<section class="projects-section" id="e$ID">
    <main
        class="py-3 <% if $Parent.OwnerPage.ClassName.ShortName == "HomePage" %>px-md-5 px-4 px-lg-5<% end_if %> container">
        <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col-12">
                <% if $ShowTitle %>
                    <h3 class="text-center">$Title</h3>
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
    </main>
</section>
