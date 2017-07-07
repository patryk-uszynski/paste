<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<style>
		[v-cloak] {
			display:none;
		}
		.jumbotron {
			margin-top: 2rem;
		}
	</style>
</head>
<body class="container" > 
	<div class="col-md-8 offset-md-2" id="guestbook">
		<div class="jumbotron">
			<h1>Paste</h1>
		</div>

		<form v-on:submit="onCreate">
			<div class="form-group">
				<input type="text" class="form-control input-sm" name="author" v-model="author" placeholder="Your name">
			</div>

			<div class="form-group">
				<textarea class="form-control input-sm" name="text" v-model="text" placeholder="Paste text..."></textarea>
			</div>

			<div class="form-group text-right">   
				<button type="submit" class="btn btn-primary btn-lg">Submit</button>
			</div>
		</form>

		<div class="paste" v-for="paste in pastes" v-cloak>
			<h3>Paste #@{{ paste.id }} <small>by @{{ paste.author }}</h3>
			<p>@{{ paste.text }}</p>
			<p><span class="btn btn-primary" v-on:click="onDelete(paste)">Delete</span></p>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/vue"></script>
	<script>
		new Vue({ 
			el: '#guestbook',
			data: {
				pastes: [],
				text: '',
				author: ''
			},
			created: function() {
				this.getMessages();
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
							text: this.text
						},
						url: "/api/paste",
						success: function(result) {
							this.pastes.push(result);
							this.author = ''
							this.text = ''
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
	</script>
</body>
</html>