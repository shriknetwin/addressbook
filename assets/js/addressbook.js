/*
* Added for managing address book operations.
*/
var appAddressbook = angular.module('AddressbookApp',['cp.ngConfirm','angularUtils.directives.dirPagination']);

appAddressbook.filter('getByProperty', function() {
    return function(propertyName, propertyValue, collection, id, idproperty) {
        var i=0, len=collection.length;
		if(propertyValue != '')
		{
			for (; i<len; i++) {
				if(id != '')
				{
					if (collection[i][propertyName].toLowerCase() == propertyValue.toLowerCase() && collection[i][idproperty] != id)
					{
						return collection[i];
					}
				}
				else
				{
					if (collection[i][propertyName].toLowerCase() == propertyValue.toLowerCase())
					{
						return collection[i];
					}
				}
			}
		}
        return null;
    }
});

appAddressbook.controller('addressbookController', ['$scope', '$http', '$ngConfirm', '$timeout', '$filter',function ($scope, $http, $ngConfirm, $timeout, $filter){
	$scope.routeUrl = siteUrl+'/addressbook/';

	// pagination controls
	$scope.currentPage = 1;
	$scope.TotalRecords = 0;
	$scope.RecordsPerPage = 5; // items per page
	$scope.TotalNoPages = 0;
	$scope.MaxDisplayPageNumber = 5;
	$scope.loading = false;
	$scope.submitted = false;

	//Per Page Options
	$scope.PageOption = [5,10,25,50,100];

	//Default Sorting.
	$scope.SearchTxt = '';
	$scope.SortColumn = 'firstName';
	$scope.SortReverse = true;	
	getContacts($scope.currentPage);
   function getContacts(pageNumber){
		var Sort = 'ASC';
		if($scope.SortReverse)
		   Sort = 'DESC';

		if($scope.loading == false)
			$scope.loading = true;

		var UrlParameter = "?PerPage="+$scope.RecordsPerPage+"&Page="+pageNumber+"&SortBy="+$scope.SortColumn+"&SortType="+Sort;
		if($scope.SearchTxt != '')
		{
          UrlParameter +="&Search="+$scope.SearchTxt;
		}

		$http.get($scope.routeUrl+"all"+UrlParameter)
		.then(function(response){
			$scope.currentPage  = pageNumber;		
			$scope.contacts = response.data.contacts;
			$scope.TotalRecords = parseInt(response.data.total);
			$scope.loading = false;
		});
    }
	
	
	/**
	* Change page with new page id
	*
	**/
	$scope.pageChanged = function(newPage) {
		getContacts(newPage);
	};
	
	/**
	* Function to display selected contact details.
	*
	**/
	$scope.GetContactDetails = function(editcontact)
	{
		$scope.editContact = angular.copy(editcontact);
		$('#CreateUser').modal('toggle');	
	}
	
	/**
	* Function to save current contact details
	*
	**/
	$scope.saveContact = function(){
		
		if($scope.editContact.firstName == '' || $scope.editContact.lastName == '')
		{
			$ngConfirm({
			        title: 'Error',
			        content: '<div class="text-center alerttext">Please enter required fields</div>',
			        icon: 'fa fa-check-circle text-danger',
			        theme: 'modern',
			        animation: 'scale',
			        closeAnimation: 'scale',
			        type: 'green',
			        columnClass: 'medium'			        
			    });
			return;		
		}
		var PostData 	= {
							firstName : $scope.editContact.firstName,
							lastName : $scope.editContact.lastName,
							id : $scope.editContact.id
						};
		$http({
		        method : 'POST',
		        url : $scope.routeUrl+"create",
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		        data : $.param(PostData)
		    }).then(function mySuccess(response) {
				$scope.loading = false;
				$('#CreateUser').modal('toggle');
				getContacts($scope.currentPage);
				//$.alert(response.data.message);
		        $ngConfirm({
			        title: 'Success',
			        content: '<div class="text-center alerttext">'+response.data.message+'</div>',
			        icon: 'fa fa-check-circle text-success',
			        theme: 'modern',
			        animation: 'scale',
			        closeAnimation: 'scale',
			        type: 'green',
			        columnClass: 'medium'			        
			    });
			}); 
	}
	
	/**
	* Function to show add new contact form
	*
	**/
	$scope.showContactForm = function()
	{
		$scope.editContact = {};
		$scope.editContact.id = '';
		$scope.editContact.firstName = '';
		$scope.editContact.lastName = '';
		$scope.userForm.firstName.$setUntouched();
		$scope.userForm.lastName.$setUntouched();
	}
	
	/**
	* Function to Remove contact Details.
	*
	**/
	$scope.Remove = function(id,Title,Msg)
	{
		$ngConfirm({
		  columnClass: 'medium',
          icon: 'fa fa-question text-danger',
          theme: 'modern',
          closeIcon: true,
          animation: 'scale',
          closeAnimation: 'scale',
          type: 'red',
          content: '<div class="text-center alerttext">'+Msg+'</div>',
          title: Title,
          buttons: {
	            confirm: function () {
	                $http({
				        method : "POST",
				        url : $scope.routeUrl+'delete_contact',
						headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
						data : $.param({id:id})
				    }).then(function mySuccess(response) {

				        $ngConfirm({
					        title: 'Sucessfull',
					        content: '<div class="text-center alerttext">'+response.data.message+'</div>',
					        icon: 'fa fa-check-circle text-success',
					        theme: 'modern',
					        animation: 'scale',
					        closeAnimation: 'scale',
					        type: 'green',
					        columnClass: 'medium',
					    });

					   getContacts($scope.currentPage);

				    }, function myError(response) {
				        $ngConfirm({
					        title: 'Failed',
					        content: '<div class="text-center alerttext">'+response.statusText+'</div>',
					        icon: 'fa fa-times-circle text-danger',
					        theme: 'modern',
					        animation: 'scale',
					        closeAnimation: 'scale',
					        type: 'red',
					        columnClass: 'medium',
					    });
				    });
	            },
	            cancel: function () {
	            },
	        }
	    });
	}
	
	/**
	* Function to get Search contacts list.
	*
	**/
	$scope.Search = function()
	{
		getContacts(1);
	}
	
	/**
	* Function to Sort contact Details with the Field.
	*
	**/
	$scope.sort = function(keyname)
	{
        $scope.SortColumn  = keyname;   //set the sortBy to the param passed
        $scope.SortReverse = !$scope.SortReverse; //if true make it false and vice versa

		getContacts($scope.currentPage);
  	}
	
	/**
	* Function to display selected contact details.
	*
	**/
	$scope.ShowContactDetails = function(contact_id){
		$scope.currentContactID = contact_id;
		var PostData = {
							id : contact_id
						};
		$http({
		        method : 'POST',
		        url : $scope.routeUrl+"get_details",
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		        data : $.param(PostData)
		    }).then(function mySuccess(response) {
				$('#ContactDetailsModel').modal('show');
				$scope.contactDetails = response.data.details;				
			}); 
	}
	
	/**
	* Function to show edit for contact details
	*
	**/
	$scope.editDetails = function(editContactDetails)
	{
		$scope.editContactDetails = angular.copy(editContactDetails);
		$('#CreateDetails').modal('toggle');
		$('#ContactDetailsModel').modal('toggle');		
	}
	
	/**
	* Function to save contact details
	*
	**/
	$scope.saveContactDetails = function(){
		
		if($scope.editContactDetails.type == '' || $scope.editContactDetails.value == '')
		{
			$ngConfirm({
			        title: 'Error',
			        content: '<div class="text-center alerttext">Please enter required fields</div>',
			        icon: 'fa fa-check-circle text-danger',
			        theme: 'modern',
			        animation: 'scale',
			        closeAnimation: 'scale',
			        type: 'green',
			        columnClass: 'medium'			        
			    });
			return;		
		}
		
		var PostData 	= {
							type : $scope.editContactDetails.type,
							value : $scope.editContactDetails.value,
							contact_id : $scope.editContactDetails.contact_id,
							id : $scope.editContactDetails.id
						};
		$http({
		        method : 'POST',
		        url : $scope.routeUrl+"create_details",
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		        data : $.param(PostData)
		    }).then(function mySuccess(response) {
				$('#CreateDetails').modal('toggle');
				$scope.ShowContactDetails($scope.editContactDetails.contact_id);
				$ngConfirm({
			        title: 'Success',
			        content: '<div class="text-center alerttext">'+response.data.message+'</div>',
			        icon: 'fa fa-check-circle text-success',
			        theme: 'modern',
			        animation: 'scale',
			        closeAnimation: 'scale',
			        type: 'green',
			        columnClass: 'medium'			        
			    });
			}); 
	}
	
	/**
	* Function to Remove contact  Details.
	**/
	$scope.RemoveDetails = function(contact_details,Title,Msg)
	{
		$ngConfirm({
		  columnClass: 'medium',
          icon: 'fa fa-question text-danger',
          theme: 'modern',
          closeIcon: true,
          animation: 'scale',
          closeAnimation: 'scale',
          type: 'red',
          content: '<div class="text-center alerttext">'+Msg+'</div>',
          title: Title,
          buttons: {
	            confirm: function () {
					
					$http({
				        method : "POST",
				        url : $scope.routeUrl+'delete_contact_details',
						headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
						data : $.param({id:contact_details.id,contact_id:contact_details.contact_id})
				    }).then(function mySuccess(response) {
						$scope.ShowContactDetails(response.data.contact_id);
				        $ngConfirm({
					        title: 'Sucessfull',
					        content: '<div class="text-center alerttext">'+response.data.message+'</div>',
					        icon: 'fa fa-check-circle text-success',
					        theme: 'modern',
					        animation: 'scale',
					        closeAnimation: 'scale',
					        type: 'green',
					        columnClass: 'medium',
					    }); 					   

				    }, function myError(response) {
				        $ngConfirm({
					        title: 'Failed',
					        content: '<div class="text-center alerttext">'+response.statusText+'</div>',
					        icon: 'fa fa-times-circle text-danger',
					        theme: 'modern',
					        animation: 'scale',
					        closeAnimation: 'scale',
					        type: 'red',
					        columnClass: 'medium',
					    });
				    });
	            },
	            cancel: function () {
	            },
	        }
	    });
	}
	
	/**
	* Function to display contact details for selected contact.
	*
	**/
	$scope.showContactDetailsForm = function(contact_id)
	{
		$('#ContactDetailsModel').modal('toggle');
		$scope.editContactDetails = {};	
		$scope.editContactDetails.id = '';
		$scope.editContactDetails.type = '';
		$scope.editContactDetails.value = '';
		$scope.editContactDetails.contact_id = contact_id;
		$scope.userDetailsForm.type.$setUntouched();
		$scope.userDetailsForm.value.$setUntouched();
	}
	
	
}]);