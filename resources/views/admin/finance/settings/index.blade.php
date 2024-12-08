@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Payment Settings') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa-solid fa-sack-dollar mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.finance.dashboard') }}"> {{ __('Finance Management') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Payment Settings') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection
@section('content')	
	<!-- ALL PAYMENT CONFIGURATIONS -->					
	<div class="row">
		@if ($type == 'Regular License' && $status)
			<div class="row text-center justify-content-center">
				<p class="fs-14" style="background:#FFE2E5; color:#ff0000; padding:1rem 2rem; border-radius: 0.5rem; max-width: 1200px;">{{ __('Extended License is required in order to have access to these features') }}</p>
			</div>	
		@else
			<div class="col-lg-9 col-md-12 col-xm-12">

				<form action="{{ route('admin.finance.settings.store') }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="card border-0">
						<div class="card-header">
							<h3 class="card-title">{{ __('Setup Payment Settings') }}</h3>
						</div>		
						<div class="card-body">				

							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12">			
									<div class="input-box">	
										<h6>{{ __('Default Currency') }} <span class="text-muted">({{ __('Payments/Plans/System/Payouts') }})</span></h6>
										<select id="currency" name="currency" class="form-select" data-placeholder="Choose Default Currency:">			
											@foreach(config('currencies.all') as $key => $value)
												<option value="{{ $key }}" @if(config('payment.default_system_currency') == $key) selected @endif>{{ $value['name'] }} - {{ $key }} ({!! $value['symbol'] !!})</option>
											@endforeach
										</select>									
										@error('currency')
											<p class="text-danger">{{ $errors->first('currency') }}</p>
										@enderror
									</div> 						
								</div>

								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="input-box">								
										<h6>{{ __('Tax Rate') }} (%)</h6>
										<div class="form-group">							    
											<input type="text" class="form-control @error('tax') is-danger @enderror" id="tax" name="tax" placeholder="Enter Tax Rate" value="{{ config('payment.payment_tax')}}">
										</div>
										@error('tax')
											<p class="text-danger">{{ $errors->first('tax') }}</p>
										@enderror 
									</div>							
								</div>	
								
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="input-box">
										<h6>{{ __('Decimal Points in Prices') }} <span class="text-muted">({{ __('.00') }})</span> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
										<select id="chat-feature-user" name="decimal-points" class="form-select" data-placeholder="{{ __('Allow/Deny Decimal Points in Prices') }}">
											<option value='allow' @if (config('payment.decimal_points') == 'allow') selected @endif>{{ __('Allow') }}</option>
											<option value='deny' @if (config('payment.decimal_points') == 'deny') selected @endif> {{ __('Deny') }}</option>																															
										</select>
									</div>
								</div>
							</div>
						
						</div>
					</div>

					<div class="card border-0">
						<div class="card-header">
							<h3 class="card-title"><span class="text-info">{{ __('Online') }} </span> {{ __('Payment') }}</h3>
						</div>
						<div class="card-body pb-6">

							<div class="card border-0 special-shadow">							
								<div class="card-body">
									<h6 class="fs-12 font-weight-bold mb-4"><i class="fa-brands fa-cc-paypal fs-16 mr-2"></i><span class="text-primary">Paypal</span> {{ __('Payment Gateway') }} <span class="text-primary">({{ __('All Plans') }})</span></h6>
									
									<div class="row">
										<div class="col-md-6 col-sm-12 mb-2">
											<div class="form-group">
												<label class="custom-switch">
													<input type="checkbox" name="enable-paypal" class="custom-switch-input" @if (config('services.paypal.enable')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use PayPal Prepaid') }}</span>
												</label>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group mb-4">
												<label class="custom-switch">
													<input type="checkbox" name="enable-paypal-subscription" class="custom-switch-input" @if (config('services.paypal.subscription')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use Paypal Subscription') }}</span>
												</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">								
											<div class="input-box">								
												<h6>{{ __('PayPal Client ID') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												<div class="form-group">							    
													<input type="text" class="form-control @error('paypal_client_id') is-danger @enderror" id="paypal_client_id" name="paypal_client_id" value="{{ config('services.paypal.client_id') }}" autocomplete="off">
												</div> 
												@error('paypal_client_id')
													<p class="text-danger">{{ $errors->first('paypal_client_id') }}</p>
												@enderror
											</div> 
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>{{ __('PayPal Client Secret') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('paypal_client_secret') is-danger @enderror" id="paypal_client_secret" name="paypal_client_secret" value="{{ config('services.paypal.client_secret') }}" autocomplete="off">
												</div> 
												@error('paypal_client_secret')
													<p class="text-danger">{{ $errors->first('paypal_client_secret') }}</p>
												@enderror
											</div> 
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>{{ __('Paypal Webhook URI') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('paypal_webhook_uri') is-danger @enderror" id="paypal_webhook_uri" name="paypal_webhook_uri" value="{{ config('services.paypal.webhook_uri') }}" autocomplete="off">
												</div> 
												@error('paypal_webhook_uri')
													<p class="text-danger">{{ $errors->first('paypal_webhook_uri') }}</p>
												@enderror
											</div> 
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>{{ __('Paypal Webhook ID') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('paypal_webhook_id') is-danger @enderror" id="paypal_webhook_id" name="paypal_webhook_id" value="{{ config('services.paypal.webhook_id') }}" autocomplete="off">
												</div> 
												@error('paypal_webhook_id')
													<p class="text-danger">{{ $errors->first('paypal_webhook_id') }}</p>
												@enderror
											</div> 
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>{{ __('PayPal Base URI') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<select id="paypal-url" name="paypal_base_uri" class="form-select" data-placeholder="{{ __('Choose Payment Option') }}:">			
													<option value="https://api-m.paypal.com" @if (config('services.paypal.base_uri')  == 'https://api-m.paypal.com') selected @endif>Live URL</option>
													<option value="https://api-m.sandbox.paypal.com" @if (config('services.paypal.base_uri')  == 'https://api-m.sandbox.paypal.com') selected @endif>Sandbox URL</option>
												</select>
												@error('paypal_base_uri')
													<p class="text-danger">{{ $errors->first('paypal_base_uri') }}</p>
												@enderror
											</div> 
										</div>
									
									</div>
		
								</div>
							</div>	


							<div class="card overflow-hidden border-0 special-shadow">							
								<div class="card-body">

									<h6 class="fs-12 font-weight-bold mb-4"><i class="fa-brands fa-cc-stripe fs-16 mr-2"></i><span class="text-primary">Stripe</span> {{ __('Payment Gateway') }} <span class="text-primary">({{ __('All Plans') }})</span></h6>

									<div class="row">
										<div class="col-md-6 col-sm-12 mb-2">
											<div class="form-group">
												<label class="custom-switch">
													<input type="checkbox" name="enable-stripe" class="custom-switch-input" @if (config('services.stripe.enable')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use Stripe Prepaid') }}</span>
												</label>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group mb-4">
												<label class="custom-switch">
													<input type="checkbox" name="enable-stripe-subscription" class="custom-switch-input" @if (config('services.stripe.subscription')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use Stripe Subscription') }}</span>
												</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">								
											<!-- ACCESS KEY -->
											<div class="input-box">								
												<h6>Stripe Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												<div class="form-group">							    
													<input type="text" class="form-control @error('stripe_key') is-danger @enderror" id="stripe_key" name="stripe_key" value="{{ config('services.stripe.api_key') }}" autocomplete="off">
												</div> 
												@error('stripe_key')
													<p class="text-danger">{{ $errors->first('stripe_key') }}</p>
												@enderror
											</div> <!-- END ACCESS KEY -->
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<!-- SECRET ACCESS KEY -->
											<div class="input-box">								
												<h6>Stripe Secret Key <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('stripe_secret_key') is-danger @enderror" id="stripe_secret_key" name="stripe_secret_key" value="{{ config('services.stripe.api_secret') }}" autocomplete="off">
												</div> 
												@error('stripe_secret_key')
													<p class="text-danger">{{ $errors->first('stripe_secret_key') }}</p>
												@enderror
											</div> <!-- END SECRET ACCESS KEY -->
										</div>	
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>Stripe Webhook URI <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('stripe_webhook_uri') is-danger @enderror" id="stripe_webhook_uri" name="stripe_webhook_uri" value="{{ config('services.stripe.webhook_uri') }}" autocomplete="off">
												</div> 
												@error('stripe_webhook_uri')
													<p class="text-danger">{{ $errors->first('stripe_webhook_uri') }}</p>
												@enderror
											</div> 
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>Stripe Webhook Secret <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('stripe_webhook_secret') is-danger @enderror" id="stripe_webhook_secret" name="stripe_webhook_secret" value="{{ config('services.stripe.webhook_secret') }}" autocomplete="off">
												</div> 
												@error('stripe_webhook_secret')
													<p class="text-danger">{{ $errors->first('stripe_webhook_secret') }}</p>
												@enderror
											</div> 
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>Stripe Base URI <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<div class="form-group">							    
													<input type="text" class="form-control @error('stripe_base_uri') is-danger @enderror" id="stripe_base_uri" name="stripe_base_uri" value="{{ config('services.stripe.base_uri') }}" autocomplete="off">
												</div> 
												@error('stripe_base_uri')
													<p class="text-danger">{{ $errors->first('stripe_base_uri') }}</p>
												@enderror
											</div> 
										</div>
										
									</div>
		
								</div>
							</div>



						</div>
					</div>


		<div class="card border-0" style="display:none">
						<div class="card-header">
							<h3 class="card-title"><span class="text-info">{{ __('Cryptocurrency') }} </span> {{ __('Payment') }}</h3>
						</div>
						<div class="card-body pb-6">
		
							<div class="card overflow-hidden border-0 special-shadow">							
								<div class="card-body">
		
									<h6 class="fs-12 font-weight-bold mb-4"><img src="{{ URL::asset('/img/payments/coinbase.svg') }}" alt="Coinbase" class="gateway-logo">{{ __('Coinbase Commerce Payment Gateway') }} <span class="text-primary">({{ __('Prepaid Plans') }})</span></h6>
		
									<div class="row">
										<div class="col-md-6 col-sm-12">
											<div class="form-group mb-4">
												<label class="custom-switch">
													<input type="checkbox" name="enable-coinbase" class="custom-switch-input" @if (config('services.coinbase.enable')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">Use Coinbase Prepaid</span>
												</label>
											</div>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">		
											<div class="input-box">								
												<h6>Coinbase API Key</h6>
												<div class="form-group">							    
													<input type="text" class="form-control @error('coinbase_api_key') is-danger @enderror" id="coinbase_api_key" name="coinbase_api_key" value="{{ config('services.coinbase.api_key') }}" autocomplete="off">
												</div>
													@error('coinbase_api_key')
													<p class="text-danger">{{ $errors->first('coinbase_api_key') }}</p>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">		
											<div class="input-box">								
												<h6>Coinbase Webhook Secret</h6>
												<div class="form-group">							    
													<input type="text" class="form-control @error('coinbase_webhook_secret') is-danger @enderror" id="coinbase_webhook_secret" name="coinbase_webhook_secret" value="{{ config('services.coinbase.webhook_secret') }}" autocomplete="off">
												</div>
													@error('coinbase_webhook_secret')
													<p class="text-danger">{{ $errors->first('coinbase_webhook_secret') }}</p>
												@enderror
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">		
											<div class="input-box">								
												<h6>Coinbase Webhook URI</h6>
												<div class="form-group">							    
													<input type="text" class="form-control @error('coinbase_webhook_uri') is-danger @enderror" id="coinbase_webhook_uri" name="coinbase_webhook_uri" value="{{ config('services.coinbase.webhook_uri') }}" autocomplete="off">
												</div>
													@error('coinbase_webhook_uri')
													<p class="text-danger">{{ $errors->first('coinbase_webhook_uri') }}</p>
												@enderror
											</div>
										</div>
									</div>
		
								</div>
							</div>
						
						</div>					
					
					</div>





					<div class="card border-0">
						<div class="card-header">
							<h3 class="card-title"><span class="text-info">{{ __('Offline') }} </span> {{ __('Payment') }}</h3>
						</div>
						<div class="card-body">

							<div class="card overflow-hidden border-0 special-shadow">							
								<div class="card-body">

									<h6 class="fs-12 font-weight-bold mb-4"><i class="fa-solid fa-money-check-dollar-pen fs-16 mr-2"></i>{{ __('Bank Transfer Payment') }} <span class="text-primary">({{ __('All Plans') }})</span></h6>

									<div class="row">
										<div class="col-md-6 col-sm-12 mb-2">
											<div class="form-group">
												<label class="custom-switch">
													<input type="checkbox" name="enable-bank" class="custom-switch-input" @if (config('services.banktransfer.enable')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use Bank Transfer Prepaid') }}</span>
												</label>
											</div>
										</div>
										<div class="col-md-6 col-sm-12">
											<div class="form-group mb-4">
												<label class="custom-switch">
													<input type="checkbox" name="enable-bank-subscription" class="custom-switch-input" @if (config('services.banktransfer.subscription')  == 'on') checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-description">{{ __('Use Bank Transfer Subscription') }}</span>
												</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">								
											<div class="input-box">								
												<h6>{{ __('Customer Payment Intructions') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
												<textarea class="form-control" name="bank_instructions" id="bank_instructions" rows="6">{{ $bank['bank_instructions'] }}</textarea> 
												@error('bank_instructions')
													<p class="text-danger">{{ $errors->first('bank_instructions') }}</p>
												@enderror
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="input-box">								
												<h6>{{ __('Bank Account Requisites') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6> 
												<textarea class="form-control" name="bank_requisites" id="bank_requisites" rows="6">{{ $bank['bank_requisites'] }}</textarea>
												@error('bank_requisites')
													<p class="text-danger">{{ $errors->first('bank_requisites') }}</p>
												@enderror
											</div> 
										</div>										
										
									</div>
		
								</div>
							</div>		
				

							<!-- SAVE CHANGES ACTION BUTTON -->
							<div class="border-0 text-right mb-2 mt-1">
								<a href="{{ route('admin.finance.dashboard') }}" class="btn btn-cancel mr-2">{{ __('Cancel') }}</a>
								<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>							
							</div>
						
						</div>					
					
					</div>		
				
				</form>
					
			</div>
		@endif
	</div>
	<!-- END ALL PAYMENT CONFIGURATIONS -->	

@endsection
