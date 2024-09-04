<!doctype html>
<html lang="pt">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/d4e287a7cd.js" crossorigin="anonymous"></script>

	<!-- Tables -->
	<!-- Bootstrap Table -->
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.17.1/dist/bootstrap-table.min.css">
	<link href="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css" rel="stylesheet">
	<!-- End Bootstrap Table -->

	<link rel="stylesheet" href="/admin/css/styles.css?v=12022021_1615" />

	<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" />

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



	@if(isset($title))
	<title>{{ ucfirst($title ?? '') }}</title>
	@else
	<title>@yield('title')</title>
	@endif

	<style>
		[contenteditable] {
			border: solid 1px lightgreen;
			padding: 5px;
			border-radius: 3px;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="/">
			<img src="/admin/img/logo-fundo-data.jpg" alt="Data Decisões" style="width:90px">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			@auth
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Menu
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a href="/proposal" class="dropdown-item">Orçamentos</a>
						<a href="/service" class="dropdown-item">Serviços</a>
						<a href="/category" class="dropdown-item">Categorias</a>
						<a href="/package" class="dropdown-item">Packs</a>
						<a href="/order" class="dropdown-item">Encomendas</a>
						<a href="/material" class="dropdown-item">Materiais</a>
						<a href="/supplier" class="dropdown-item">Fornecedores</a>
					</div>
				</li>
			</ul>
			@endauth
			@if (Route::has('login'))
			<div class="top-right links">
				@auth
				<!-- <a href="{{ url('/home') }}">Home</a> -->
				<form id="logout-form" action="{{ route('logout') }}" method="POST">
					@csrf
					@method('POST')
					<button type="submit" class="btn btn-danger">Logout</button>
				</form>
				@else
				<a href="{{ route('login') }}">Login</a>

				<!-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registar</a>
                        @endif -->
				@endauth
			</div>
			@endif
		</div>

	</nav>
	<section>
		<div class="d-flex" id="wrapper">
			<!-- Sidebar -->
			<!-- <div class="bg-light border-right" id="sidebar-wrapper">

			</div> -->

			<div class="col">
				@yield('content')

				<div role="alert" aria-live="assertive" aria-atomic="true" class="toast toast-success" data-autohide="false">
					<div class="toast-header">
						<!-- 				<img src="..." class="rounded mr-2" alt="..."> -->
						<i class="fas fa-check-circle"></i>
						<strong class="mr-auto">Sucesso</strong>
						<small>Agora mesmo</small>
						<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="toast-body">
						Guardado com sucesso!
					</div>
				</div>

				<div role="alert" aria-live="assertive" aria-atomic="true" class="toast toast-error" data-autohide="false">
					<div class="toast-header">
						<!-- 				<img src="..." class="rounded mr-2" alt="..."> -->
						<i class="fas fa-exclamation-circle"></i>
						<strong class="mr-auto">Erro</strong>
						<small>Agora mesmo</small>
						<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="toast-body">
						Ocorreu um erro ao guardar!
					</div>
				</div>

			</div>
		</div>

	</section>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script> -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js">
	</script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
	</script>


	<!-- Bootstrap Table -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/1.0.3/jquery.tablednd.min.js"></script>
	<script src="/admin/js/libs/bootstrap-table/bootstrap-table.min.js"></script>
	<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js"></script>
	<!-- <script src="/admin/js/libs/bootstrap-table/extensions/editable/bootstrap-table-editable.js"></script> -->
	<!-- <script src="https://github.com/wenzhixin/bootstrap-table/blob/master/src/extensions/editable/bootstrap-table-editable.js"></script> -->
	<!-- Latest compiled and minified Locales -->
	<script src="https://unpkg.com/bootstrap-table@1.17.1/dist/locale/bootstrap-table-pt-PT.min.js"></script>
	<!-- End Bootstrap Table -->

	<!-- Autocomplete -->
	<!--     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> -->
	<!--     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->

	<!--<script src="/admin/js/tautocomplete.js"></script>-->
	<script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.5/dist/latest/bootstrap-autocomplete.min.js"></script>

	<!-- Table Export -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.min.js"></script>
	<script src="https://cdn.rawgit.com/eligrey/FileSaver.js/e9d941381475b5df8b7d7691013401e171014e89/FileSaver.min.js"></script>
	<script src="https://unpkg.com/tableexport@5.2.0/dist/js/tableexport.min.js"></script>

	<!-- <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->
	<!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->

	<!-- <script src="/admin/js/libs/html2pdf.js"></script>
	<script src="/admin/js/jspdf.min.js"></script> -->

	<!-- <script src="/admin/js/bootstrap-table-pt-PT.js"></script> -->

	<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

	<script src="/admin/js/libs/bootstrap-notify.min.js"></script>


	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var $table = $('#tableInModal')

		$(function() {
			$('#modalTable').on('shown.bs.modal', function() {
				$table.bootstrapTable('resetView')
			})
		})

		var $tableCategories = $('#tableInModalCategories')

		$(function() {
			$('#modalTableCategories').on('shown.bs.modal', function() {
				$tableCategories.bootstrapTable('resetView')
			})
		})

		var $tablePacks = $('#tableInModalPacks')

		$(function() {
			$('#modalTablePacks').on('shown.bs.modal', function() {
				$tablePacks.bootstrapTable('resetView')
			})
		})
	</script>



	@stack('scripts')

	@push('scripts')


	@endpush @yield('footer-scripts')
</body>

</html>
