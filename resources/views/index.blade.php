<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Project</title>

        @php $public = url('/'); @endphp

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/style.css">
        <!-- Starter CMS CSS file -->
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    </head>
    <body>

     <div class="container">
	 <!-- Header -->
	 <header id="layout-header">
        @include('partials.site.header')
	 </header>

	 <!-- Content -->
	 <section id="layout-content" class="pt-4">
        @include ('layouts.flash-messages')
        @include('pages.'.$page)

        @if ($page == 'operation') 
            <script type="text/javascript" src="{{ url('/') }}/js/lang/fr.js"></script>
            <script type="text/javascript" src="{{ url('/') }}/js/crepeater.js"></script>
            <script type="text/javascript" src="{{ url('/') }}/js/operation.js"></script>
        @elseif ($page == 'operations') 
            <script type="text/javascript" src="{{ url('/') }}/js/operations.js"></script>
        @endif
	 </section>

	 <!-- Footer -->
	 <footer id="layout-footer" class="page-footer pt-4">
        @include('partials.site.footer')
	 </footer>
     </div>
    </body>
</html>
