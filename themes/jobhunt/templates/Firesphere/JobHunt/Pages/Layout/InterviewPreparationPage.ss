<div class="">
    <div class="row">
        <h1 class="col-12">$Title</h1>
        <div class="col-12">
            $Content
        </div>
        <div class="col-12">
            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Company</th>
                    <th scope="col">Role</th>
                    <th scope="col">Preparation(s)</th>
                    <th scope="col">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <% loop $InterviewList.Sort('DateTime', 'DESC') %>
                    <tr>
                        <th scope="row">$DateTime.Nice()</th>
                        <td>$Application.Company.Name</td>
                        <td>$Application.Role</td>
                        <td>
                            <% if $Preparation.Count() %>
                                <% loop $Preparation %>
                                    <a href="$Link">$Pos</a><% if not $isLast %>&nbsp;|&nbsp;<% end_if %>
                                <% end_loop %>
                            <% else %>
                                No
                            <% end_if %>
                        </td>
                        <td><a href="$PreparationLink" title="add preparation"><i class="bi bi-journal-plus"></i></a></td>
                    </tr>
                <% end_loop %>
                </tbody>
            </table>
        </div>
    </div>
</div>
