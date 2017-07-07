@extends('master')

@section('content')
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
@endsection

@section('scripts')	
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
@endsection