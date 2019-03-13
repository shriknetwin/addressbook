<div ng-app="AddressbookApp">	
	<div ng-controller="addressbookController">	
	

 <div class="container">
        <!--div class="overlay" ng-show="loading"><div class="overlay-content"><img src="<?php echo $this->config->item('ASSESTS_PATH');?>img/loading.gif" alt="Loading..." width="80px;" /></div></div-->
        <div class="card-header border-0">
  				<div class="row">
  					<div class="col-md-6">
  						<h3 class="mb-0">
  							<button class="btn btn-icon btn-3 btn-success" type="button" data-toggle="modal" data-target="#CreateUser" ng-click="showContactForm()">
  								<span class="btn-inner--icon"><i class="fa fa-user-plus"></i></span>
  								<span class="btn-inner--text">Create Contact</span>
  							</button>
  						</h3>
  					</div>
  					<div class="col-md-6">
  						<input type="text" class="form-control input-sm ng-valid ng-dirty" placeholder="Search" ng-change="Search()" ng-model="SearchTxt" name="SearchTxt">
  					</div>
  				</div>
        </div>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead class="thead-light">
              <tr>
                <th scope="col">Sr.No</th>
                <th scope="col" class="clsPointer" ng-click="sort('firstName')">First name
					<span class="fa fa-angle-down" ng-show="SortColumn=='firstName'" ng-class="{'fa fa-angle-down':SortReverse,'fa fa-angle-up':!SortReverse}"></span>
				</th>
                <th scope="col" class="clsPointer" ng-click="sort('lastName')">Last name
					<span class="fa fa-angle-down" ng-show="SortColumn=='lastName'" ng-class="{'fa fa-angle-down':SortReverse,'fa fa-angle-up':!SortReverse}"></span>
				</th>
				<th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-show="contacts.length != 0" dir-paginate="contact in contacts | filter:SearchTxt | orderBy:SortColumn:SortReverse | itemsPerPage:RecordsPerPage" current-page="currentPage" total-items="TotalRecords" pagination-id="UsersList">
                <td>{{ $index + 1 }}</td>
      					<td>{{ contact.firstName }}</td>
      					<td>{{ contact.lastName }}</td>
      					
      					<td>
							<button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit contact details" onmouseenter="$(this).tooltip('show')" ng-click="GetContactDetails(contact)">
      							<i class="fa fa-pencil"></i>
      						</button>
							<button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="View contact details" onmouseenter="$(this).tooltip('show')" ng-click="ShowContactDetails(contact.id)">
      							<i class="fa fa-eye"></i>
      						</button>
      						<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete contact" onmouseenter="$(this).tooltip('show')" ng-click="Remove( contact.id,'Contact Delete','Are you sure to delete this contact?');">
      							<i class="fa fa-trash"></i>
      						</button>
      					</td>
              </tr>
			  <tr></tr>
              <tr ng-show="contacts.length == 0">
              	<td colspan="7" style="color:#FF0000; font-size: 16px; font-weight: bold; text-align: center;">No records found</td>
              </tr>
            </tbody>
          </table>
	      </div>
        <div class="card-footer py-4">
          <nav>
  				  <div class="row">
  					<!-- Select Records Per Page -->
  					<div class="col-md-6" ng-show="TotalRecords > 0"><div>Show <select class="form-control" ng-model="RecordsPerPage" ng-change="GetAllUsers(currentPage)" ng-options="option for option in PageOption" style="display: inline; width: 70px;"></select> records per page!</div></div>
  					<!-- angular pagination -->
  					<div class="col-md-6"><dir-pagination-controls pagination-id="UsersList" boundary-links="true" on-page-change="pageChanged(newPageNumber)" template-url="<?php echo $this->config->item('ASSESTS_PATH');?>js/dirPagination.html"></dir-pagination-controls></div>
  				  </div>
  			  </nav>
	      </div>
    </div>
	<!-- START : User Create Modal -->
		<div class="modal fade" id="CreateUser" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
            	<span class="requiredMark">* </span> <strong> Required fields</strong>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			    </div>
				<div class="modal-body">
					<form name="userForm" ng-submit="createContact(userForm.$valid)" novalidate>
						<div class="row">
							<!-- User Name -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group" ng-class="{'has-error': userForm.firstName.$touched && userForm.firstName.$invalid}">
									<div class="col-sm-6">
										<label for="Name">First Name<span class="requiredMark">*</span></label>
									</div>
									
									<div class="col-sm-6">
										<input type="text" name="firstName" id="firstName" class="form-control" ng-model="editContact.firstName" required>
										<span ng-show="userForm.firstName.$touched && userForm.firstName.$invalid" class="help-block">First Name required</span>
									</div>									
								</div>
							</div>	
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group" ng-class="{'has-error': userForm.lastName.$touched && userForm.lastName.$invalid}">
									<div class="col-sm-6">
										<label for="Name">Last Name<span class="requiredMark">*</span></label>
									</div>
									
									<div class="col-sm-6">
										<input type="text" name="lastName" id="lastName" class="form-control" ng-model="editContact.lastName" required>
										<span ng-show="userForm.lastName.$touched && userForm.lastName.$invalid" class="help-block">First Name required</span>
									</div>									
								</div>
							</div>	
						</div> 
						<div class="row">
							<!-- User Name -->
							<div class="col-12" style="text-align:center;">
								<button type="button" class="btn btn-success btn-icon" data-toggle="tooltip" ng-click="saveContact()">Save</button>
							</div>
						</div>		
					</form>
				</div>
			 </div>
		  </div>
		</div>
		<!-- END : User Create Modal -->

		<!-- START : User emails and numbers Modal -->
		<div class="modal fade" id="ContactDetailsModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<div class="col-12">
					<div class="col-6">
						<strong>Contact Details</strong>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						
					</div>
					<div class="col-6">
						<button class="btn btn-icon btn-3 btn-success" type="button" data-toggle="modal" data-target="#CreateDetails" ng-click="showContactDetailsForm(currentContactID)">
							<span class="btn-inner--icon"><i class="fa fa-user-plus"></i></span>
							<span class="btn-inner--text">Add new details</span>
							</button>
					</div>
				</div>					
				</div>     	
            	
				<div class="modal-body">
					<table class="table table-striped">
						<tr>
							<th>Sr.No</th>
							<th>Type</th>
							<th>Value</th>
							<th>Action</th>
						</tr>
						<tr ng-repeat="details in contactDetails">
							<td>{{ $index + 1 }}</td>
							<td>{{details.type}}</td>
							<td>{{details.value}}</td>
							<td>
							<button type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit contact details" onmouseenter="$(this).tooltip('show')" ng-click="editDetails(details)">
      							<i class="fa fa-pencil"></i>
      						</button>							
      						<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete contact Details" onmouseenter="$(this).tooltip('show')" ng-click="RemoveDetails( details,'Delete Contact Details','Are you sure to delete this contact details?');">
      							<i class="fa fa-trash"></i>
      						</button>
      					</td>
						</tr>
					</table>
				</div>
			 </div>
		  </div>
		</div>
		<!-- END : User Create Modal -->	
		
		<!-- START : Edit details Modal -->
		<div class="modal fade" id="CreateDetails" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
            	<span class="requiredMark">* </span> <strong> Required fields</strong>
			        <button type="button" class="close" data-dismiss="modal" ng-click="ShowContactDetails(currentContactID)">&times;</button>
			    </div>
				<div class="modal-body">
					<form name="userDetailsForm" ng-submit="createContactDetails(userDetailsForm.$valid)" novalidate>
						<div class="row">
							<!-- User Name -->
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group" ng-class="{'has-error': userDetailsForm.type.$touched && userDetailsForm.type.$invalid}">
									<div class="col-sm-6">
										<label for="Name">Type<span class="requiredMark">*</span></label>
									</div>
									
									<div class="col-sm-6">
										<select ng-model="editContactDetails.type">
											<option>email</option>
											<option>phonenumber</option>
										</select>
									</div>									
								</div>
							</div>	
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group" ng-class="{'has-error': userDetailsForm.value.$touched && userDetailsForm.value.$invalid}">
									<div class="col-sm-6">
										<label for="Name">Value<span class="requiredMark">*</span></label>
									</div>
									
									<div class="col-sm-6">
										<input type="text" name="value" id="value" class="form-control" ng-model="editContactDetails.value" required>
										<span ng-show="userDetailsForm.value.$touched && userDetailsForm.value.$invalid" class="help-block">value required</span>
									</div>
								</div>
							</div>	
						</div> 
						<div class="row">
							<!-- User Name -->
							<div class="col-12" style="text-align:center;">
								<button type="button" class="btn btn-success btn-icon" data-toggle="tooltip" ng-click="saveContactDetails()">Save</button>
							</div>
						</div>		
					</form>
				</div>
			 </div>
		  </div>
		</div>
		<!-- END : User Create Modal -->
</div>
</div>	

