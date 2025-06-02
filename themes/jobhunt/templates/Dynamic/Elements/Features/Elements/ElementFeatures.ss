<section class="$Type projects-section py-3" id="e$ID">
    <main
        class="py-3 <% if $Parent.OwnerPage.ClassName.ShortName == "HomePage" %>px-md-5 px-4 px-lg-5<% end_if %> container">
    <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
            <div class="col-xl-$ImageWidth col-lg-$ImageLGWidth">
                $Image.ResponsiveSet1
            </div>
            <div class="col-xl-$TXTWidth col-lg-$TXTLGWidth <% if $Alternate %>order-lg-first<% end_if %>">
                <div class="featured-text<% if $Alternate %>-inverse<% end_if %> $TextClass text-lg-left">
                    <% if $ShowTitle %>
                        <h3>$Title</h3>
                    <% end_if %>
                    <div class="text-black-50 mb-0">
                        $Content
                    </div>
                </div>
            </div>
        </div>

        <% if $FeaturesList %>
            <% loop $FeaturesList %>
                <div class="row gx-0 py-2 <% if $First %>mb-5 mb-lg-0<% end_if %> justify-content-center
<% if $Even %>bg-light<% else %>bg-secondary<% end_if %> bg-gradient">
                    <% if $Even %>
                        <div class="col-lg-6 img-fluid">$Image.ResponsiveSet1</div>
                    <% end_if %>
                    <div class="col-lg-6">
                        <div class="text-center h-100 project">
                            <div class="d-flex h-100">
                                <div class="project-text w-100 my-auto text-center">
                                    <h4>
                                        <% if $ElementLink %>
                                            <a href="$ElementLink.getLinkURL" $getTargetAttr >
                                                $Title
                                            </a>
                                        <% else %>
                                            $Title
                                        <% end_if %>
                                    </h4>
                                    <div class="mb-0 px-md-5 px-sm-2">$Content</div>
                                    <hr class="d-none d-lg-block mb-0 ms-0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <% if $Odd %>
                        <div class="col-lg-6 img-fluid">$Image.ResponsiveSet1</div>
                    <% end_if %>

                </div>
            <% end_loop %>
        <% end_if %>
    </main>
</section>
