const poll = (function(){

	const view = {
		root: $('.choices'),

		init(){
			this.cacheDOM();
			this.bindEvents();
		},

		cacheDOM(){			
			this.voteButton = $('#vote');			
			this.shareButton = $('#share');
		},

		bindEvents(){
			this.voteButton.on('click', controller.vote);
			this.shareButton.on('click', function(){

			});		
		},

		getSelectedRadio(){			
			return this.root.find('input[name="choice"]:checked').val();
		}
	};

	const controller = {
		init(){			
			view.init();			
		},

		vote(){			
			if(view.getSelectedRadio())
			{
				$.ajax({
					url: window.location.href + '/vote/' + view.getSelectedRadio(),

					type: 'GET',

					success: function(res){
						if(res.error){
							console.log(res.error);
						}

						else{							
							window.location.reload();
						}
					},

					error: function(err){
						$('body').html(err.responseText);
					}
				});
			}
		}
	}


	return{
		init: controller.init.bind(controller)		
	}
})();

$(poll.init);

