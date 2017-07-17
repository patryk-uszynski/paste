import { VueEditor } from 'vue2-editor'

new Vue({ 
	el: '#guestbook',
	data: {
		pastes: [],
		author: '',
		content: ''
	},
	created: function() {
		this.getMessages();
	},
	components: {
    	VueEditor
	},
	methods: {
		getMessages: function() {
			$.ajax({
				context: this,
				url: "/api/paste",
				success: function (result) {
					this.pastes = result;
				}
			})
		},
		onCreate: function(e) {
			e.preventDefault();
			$.ajax({
				context: this,
				type: "POST",
				data: {
					author: this.author,
					text: this.content
				},
				url: "/api/paste",
				success: function(result) {
					this.pastes.push(result);
					this.author = ''
					this.content = ''
				}
			})                        
		},
		onDelete: function (paste) {
			$.ajax({
				context: paste,
				type: "DELETE",
				url: "/api/paste/" + paste.id,
			})

			this.pastes = this.pastes.filter(function (item) {
				return paste.id != item.id;
			});
		}
	}
})
