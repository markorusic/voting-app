const dashboard = (function(){

	const csrfToken = $('meta[name="csrf-token"]').attr('content');

	const tabs = (function(){
		const state = {
			newPoll: true,
			myPolls: false
		};

		const view = {
			init(){
				this.cacheDOM();
				this.bindEvents();
			},

			cacheDOM(){
				this.root = $('.dashboard-nav');
				this.newPoll = this.root.children().first();
				this.myPolls = this.root.children().last();
			},

			bindEvents(){
				this.newPoll.on('click', controller.setNewPoll);
				this.myPolls.on('click', controller.setMyPolls);
			}

		};

		const controller = {
			init(){
				view.init();
			},

			setNewPoll(){
				if(!state.newPoll){

					state.newPoll = true;
					state.myPolls = false;

					view.myPolls.removeClass('active');
					view.newPoll.addClass('active');


					newPoll.show();
					myPolls.hide();

				}
			},

			setMyPolls(){
				if(!state.myPolls){
					state.myPolls = true;
					state.newPoll = false;

					view.newPoll.removeClass('active');
					view.myPolls.addClass('active');

					myPolls.show();
					newPoll.hide();
				}
			}
		}


		return{
			init: view.init.bind(view),
			setNewPoll: controller.setNewPoll,
			setMyPolls: controller.setMyPolls
		}
	})();

	const newPoll = (function(){

		const view = {
			init(){
				this.cacheDOM();
				this.bindEvents();				
			},

			cacheDOM(){
				this.root = $('.new-poll');				

				this.form = this.root.find('form');
				
				this.title = this.form.find('input[name="title"]');
				this.choices = this.form.find('.choices');
				this.choiceInputs = this.choices.find('input');

				this.submit = this.form.find('button[type="submit"]');
				this.newChoice = this.form.find('button.new-choice');
				// this.newChoice.hide();
			},	

			bindEvents(){
				this.submit.on('click', controller.submitNewPoll);
				// this.newChoice.on('click', this.addNewChoiceField.bind(this));				
				
				this.choiceInputs.on('keyup', this.addNewChoiceField.bind(this));
			},
			


			addNewChoiceField(e){
				if(this.getChoices().length >= this.choiceInputs.length){

					const newField = this.choices.children().last().clone();
					newField.val('');
					newField.on('keyup', this.addNewChoiceField.bind(this));

					newField.appendTo(this.choices);

					this.choices = this.form.find('.choices');		
					this.choices.children().last().children().first().val('');

					this.choiceInputs = this.choices.find('input');
				}
			},

			getChoices(){
				return [...this.choices.find('input')].map(e => e.value.trim()).filter(e => e !== "");
			},

			resetForm(){
				this.title.val('');

				while(this.choices.children().length > 3){
					this.choices.children().last().remove();
					this.choices = this.form.find('.choices');
				}

				[...this.choices.find('input')].forEach(e => $(e).val('') );				
			},

			hide(){
				this.root.hide();
				// this.resetForm();
			},

			show(){
				this.root.show();
			}

		};

		const controller = {
			init(){
				view.init();				
			},

			submitNewPoll(e){
				e.preventDefault();
				const title = view.title.val();
				const choices = view.getChoices();
				if(title.length > 0 && choices.length > 1){
					$.ajax({
						url: '/dashboard',
						type: 'POST',
						data: {
							_token: csrfToken,
							title,
							choices
						},

						success: function(res){
							view.resetForm();
							myPolls.add({
								title: res.title,
								id: res.id,
								link: window.location.origin + '/polls/' + res.id
							});
							tabs.setMyPolls();
						},

						error: function(err){		
							$('body').html(err.responseText);
						}
					});	
				}

				else{
					//render errors
				}
				
			}
		};

		return{
			init: controller.init,
			hide: view.hide.bind(view),
			show: view.show.bind(view)
		}

	})();


	const myPolls = (function(){	

		const view = {
			root: $('.poll-list'),

			init(){
				this.cacheDOM();
				this.bindEvents();
			},

			cacheDOM(){
				this.deletePoll = this.root.find('.delete-poll');
			},

			bindEvents(){	
				this.deletePoll.on('click', function(e){
					e.preventDefault();
					controller.deletePoll($(this).data().id);				
				});
			},

			deleteById(id){				
				[...this.deletePoll].forEach(e => {
					if($(e).data().id == id)
						$(e).parent().parent().remove();
				});

				// this.root = $('.poll-list');
				this.cacheDOM();
			}

		};

		const controller = {
			init(){
				view.init();
			},

			deletePoll(id){				
				$.ajax({
					url: `/dashboard/${id}`,

					type: 'DELETE',

					data: { _token: csrfToken },

					success: function(res){
						res.id == id ? view.deleteById(id):'';												
					},

					error: function(err){		
						$('body').html(err.responseText);
					}
				});					
			}
		}

		return{
			init(){
				controller.init();
			},

			add(data){
				view.root.prepend(`
					<li class='list-group-item'>
                        <h4>
                            <a href="${data.link}">
                                ${data.title}
                            </a>
                            <a  data-id="${data.id}" 
                                href="#" 
                                class="btn btn-danger btn-xs delete-poll"
                            >
                                X
                            </a>
                        </h4>
                    </li>
				`);
				view.init();
			},

			hide(){
				$('.my-polls').hide();
			},

			show(){
				$('.my-polls').show();
			}
		}
	})();

	
	return{
		init(){
			newPoll.init();
			tabs.init();
			myPolls.init();
		}
	}

})();

$(dashboard.init);