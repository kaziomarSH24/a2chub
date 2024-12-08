<!-- SIDE MENU BAR -->
<aside class="app-sidebar"> 
    <div class="app-sidebar__logo">
        <a class="header-brand" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(URL::asset('img/brand/logo.png')); ?>" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="<?php echo e(URL::asset('img/brand/favicon.png')); ?>" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
    <ul class="side-menu app-sidebar3">
        <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('AI Panel')); ?></li>
       <li class="slide">
    <a class="side-menu__item" href="<?php echo e(route('user.dashboard')); ?>">
        <img src="<?php echo e(asset('img/frontend/features/layout.png')); ?>" alt="Dashboard Logo" class="side-menu__icon" style="width: 40px; height: 40px;">
        <span class="side-menu__label"><?php echo e(__('Dashboard')); ?></span>
    </a>
</li>

        <?php if(config('settings.chat_feature_user') == 'allow'): ?>
            <li class="slide">
                <a class="side-menu__item" href="https://a2chub.com/user/chats/custom/asst_Kan6u7rYewcIeEryv75i3nsa">
        <img src="<?php echo e(asset('img/frontend/features/chat2.png')); ?>" alt="Dashboard Logo" class="side-menu__icon" style="width: 40px; height: 40px;">
                <span class="side-menu__label"><?php echo e(__('AI Assistant')); ?></span></a>
            </li> 
        <?php endif; ?>
        
    
        <li class="slide active">
            <a class="side-menu__item" href="<?php echo e(route('user.add.data')); ?>">
            <span class="side-menu__icon lead-3 fa-solid fa-box-circle-check"></span>
            <span class="side-menu__label">Additional Data</span></a>
        </li>

      
        <li class="slide mb-3" style="display:none">
            <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
        <img src="<?php echo e(asset('img/frontend/features/folder.png')); ?>" alt="Dashboard Logo" class="side-menu__icon" style="width: 40px; height: 40px;">
                <span class="side-menu__label"><?php echo e(__('Documents')); ?></span><i class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li><a href="<?php echo e(route('user.documents')); ?>" class="slide-item"><?php echo e(__('All Documents')); ?></a></li>
                    <?php if(config('settings.image_feature_user') == 'allow'): ?>
                        <li><a href="<?php echo e(route('user.documents.images')); ?>" class="slide-item"><?php echo e(__('All Images')); ?></a></li> 
                    <?php endif; ?> 
                  
                
                    
                    <li><a href="<?php echo e(route('user.workbooks')); ?>" class="slide-item"><?php echo e(__('Workbooks')); ?></a></li>                    
                </ul>
        </li>       
        <hr class="w-90 text-center m-auto">
        <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('Account')); ?></li>
        <li class="slide">
            <a class="side-menu__item" href="<?php echo e(route('user.plans')); ?>">
            <span class="side-menu__icon lead-3 fa-solid fa-box-circle-check"></span>
            <span class="side-menu__label"><?php echo e(__('Subscription Plans')); ?></span></a>
        </li>
        <?php if(config('settings.team_members_feature') == 'allow'): ?>
            <li class="slide">
                <a class="side-menu__item" href="<?php echo e(route('user.team')); ?>">
                <span class="side-menu__icon lead-3 fa-solid fa-people-arrows"></span>
                <span class="side-menu__label"><?php echo e(__('Team Members')); ?></span></a>
            </li>
        <?php endif; ?> 
        <li class="slide">
            <a class="side-menu__item" href="<?php echo e(route('user.profile')); ?>">
            <span class="side-menu__icon lead-3 fa-solid fa-id-badge"></span>
            <span class="side-menu__label"><?php echo e(__('My Account')); ?></span></a>
        </li>
        <?php if(config('payment.referral.enabled') == 'on'): ?>
            <li class="slide mb-3">
                <a class="side-menu__item" href="<?php echo e(route('user.referral')); ?>">
                <span class="side-menu__icon lead-3 fa-solid fa-badge-dollar"></span>
                <span class="side-menu__label"><?php echo e(__('Affiliate Program')); ?></span></a>
            </li>
        <?php endif; ?> 
        <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'admin')): ?>
            <hr class="w-90 text-center m-auto">
            <li class="side-item side-item-category mt-4 mb-3"><?php echo e(__('Admin Panel')); ?></li>
            <li class="slide">
                <a class="side-menu__item"  href="<?php echo e(route('admin.dashboard')); ?>">
                    <span class="side-menu__icon fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label"><?php echo e(__('Dashboard')); ?></span>
                </a>
            </li>
            <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                        <span class="side-menu__icon fa-solid fa-microchip-ai fs-18"></span>
                        <span class="side-menu__label"><?php echo e(__('AI Management')); ?></span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.davinci.dashboard')); ?>" class="slide-item"><?php echo e(__('AI Usage Dashboard')); ?></a></li>                        
                        <li><a href="<?php echo e(route('admin.davinci.configs')); ?>" class="slide-item"><?php echo e(__('AI Settings')); ?></a></li>
                    </ul>
            </li>
         
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-brain-circuit fs-18"></span>
                    <span class="side-menu__label"><?php echo e(__('Chat Settings')); ?></span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">                                       
                    <li><a href="<?php echo e(route('admin.davinci.chat.category')); ?>" class="slide-item"><?php echo e(__('Chat Categories')); ?></a></li>
                    <li><a href="<?php echo e(route('admin.chat.assistant')); ?>" class="slide-item"><?php echo e(__('Chat Assistants')); ?></a></li>                   
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-id-badge"></span>
                    <span class="side-menu__label"><?php echo e(__('User Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.user.dashboard')); ?>" class="slide-item"><?php echo e(__('User Dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.user.list')); ?>" class="slide-item"><?php echo e(__('User List')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.user.activity')); ?>" class="slide-item"><?php echo e(__('Activity Monitoring')); ?></a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-sack-dollar"></span>
                    <span class="side-menu__label"><?php echo e(__('Finance Management')); ?></span>
                    <?php if(auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()): ?>
                        <span class="badge badge-warning"><?php echo e(auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()); ?></span>
                    <?php else: ?>
                        <i class="angle fa fa-angle-right"></i>
                    <?php endif; ?>
                </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.finance.dashboard')); ?>" class="slide-item"><?php echo e(__('Finance Dashboard')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.transactions')); ?>" class="slide-item"><?php echo e(__('Transactions')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.plans')); ?>" class="slide-item"><?php echo e(__('Subscription Plans')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.prepaid')); ?>" class="slide-item"><?php echo e(__('Prepaid Plans')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.subscriptions')); ?>" class="slide-item"><?php echo e(__('Subscribers')); ?></a></li>

                        <li><a href="<?php echo e(route('admin.settings.invoice')); ?>" class="slide-item"><?php echo e(__('Invoice Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.finance.settings')); ?>" class="slide-item"><?php echo e(__('Payment Settings')); ?></a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item"  href="<?php echo e(route('admin.support')); ?>">
                    <span class="side-menu__icon fa-solid fa-message-question"></span>
                    <span class="side-menu__label"><?php echo e(__('Support Requests')); ?></span>
                    <?php if(App\Models\SupportTicket::where('status', 'Open')->count()): ?>
                        <span class="badge badge-warning"><?php echo e(App\Models\SupportTicket::where('status', 'Open')->count()); ?></span>
                    <?php endif; ?> 
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-envelope-circle-check"></span>
                    <span class="side-menu__label"><?php echo e(__('Email & Notifications')); ?></span>
                        <?php if(auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count()): ?>
                            <span class="badge badge-warning" id="total-notifications-a"></span>
                        <?php else: ?>
                            <i class="angle fa fa-angle-right"></i>
                        <?php endif; ?>
                    </a>                     
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.email.newsletter')); ?>" class="slide-item"><?php echo e(__('Newsletter')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.email.templates')); ?>" class="slide-item"><?php echo e(__('Email Templates')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.notifications.system')); ?>" class="slide-item"><?php echo e(__('System Notifications')); ?> 
                                <?php if((auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())): ?>
                                    <span class="badge badge-warning ml-5" id="total-notifications-b"></span>
                                <?php endif; ?>
                            </a>
                        </li> 
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa-solid fa-earth-americas"></span>
                    <span class="side-menu__label"><?php echo e(__('Frontend Management')); ?></span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.settings.frontend')); ?>" class="slide-item"><?php echo e(__('Frontend Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.appearance')); ?>" class="slide-item"><?php echo e(__('SEO & Logos')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.step')); ?>" class="slide-item"><?php echo e(__('How it Works Section')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.tool')); ?>" class="slide-item"><?php echo e(__('AI Tools Section')); ?></a></li>                                           
                        <li><a href="<?php echo e(route('admin.settings.feature')); ?>" class="slide-item"><?php echo e(__('Features Section')); ?></a></li>                      
                        <li><a href="<?php echo e(route('admin.settings.review')); ?>" class="slide-item"><?php echo e(__('Reviews Manager')); ?></a></li>                      
                        <li><a href="<?php echo e(route('admin.settings.blog')); ?>" class="slide-item"><?php echo e(__('Blogs Manager')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.faq')); ?>" class="slide-item"><?php echo e(__('FAQs Manager')); ?></a></li>                        
                        <li><a href="<?php echo e(route('admin.settings.about')); ?>" class="slide-item"><?php echo e(__('About Us Page')); ?></a></li>                           
                        <li><a href="<?php echo e(route('admin.settings.terms')); ?>" class="slide-item"><?php echo e(__('T&C Pages')); ?></a></li>                           
                    </ul>
            </li>
            <li class="slide mb-3">
                <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('#')); ?>">
                    <span class="side-menu__icon fa fa-sliders"></span>
                    <span class="side-menu__label"><?php echo e(__('General Settings')); ?></span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('admin.settings.global')); ?>" class="slide-item"><?php echo e(__('Global Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.oauth')); ?>" class="slide-item"><?php echo e(__('Auth Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.registration')); ?>" class="slide-item"><?php echo e(__('Registration Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.smtp')); ?>" class="slide-item"><?php echo e(__('SMTP Settings')); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.clear')); ?>" class="slide-item"><?php echo e(__('Clear Cache')); ?></a></li>                 
                    </ul>
            </li>
        <?php endif; ?>
        <hr class="w-90 text-center m-auto">
        <div class="side-progress-position mt-4">
            <div class="side-plan-wrapper text-center pt-3 pb-3">
                <span class="side-item side-item-category mt-4"><?php echo e(__('Plan')); ?>: <?php if(is_null(auth()->user()->plan_id)): ?><span class="text-primary"><?php echo e(__('No Active Subscription')); ?></span> <?php else: ?> <span class="text-primary"><?php echo e(__(App\Services\HelperService::getPlanName())); ?></span>  <?php endif; ?> </span>
                <div class="view-credits mt-1" style="display:none"><a class=" fs-11 text-muted mb-2" href="javascript:void(0)" id="view-credits" data-bs-toggle="modal" data-bs-target="#creditsModel"><i class="fa-solid fa-coin-front text-yellow "></i> <?php echo e(__('View Credits')); ?></a></div> 
                <?php if(is_null(auth()->user()->plan_id)): ?>
                    <div class="text-center mt-3 mb-2"><a href="<?php echo e(route('user.plans')); ?>" class="btn btn-primary pl-6 pr-6 fs-11"> <i class="fa-solid fa-bolt text-yellow mr-2"></i> <?php echo e(__('Upgrade')); ?></a></div> 
                <?php endif; ?>              
            </div>
            <?php if(config('payment.referral.enabled') == 'on'): ?>
                <div class="side-plan-wrapper mt-4 text-center p-3 pl-5 pr-5">
                    <div class="mb-1"><i class="fa-solid fa-gifts fs-20 text-yellow"></i></div>
                    <span class="fs-12 mt-4" style="color: #344050"><?php echo e(__('Invite your friends and get')); ?> <?php echo e(config('payment.referral.payment.commission')); ?>% <?php if(config('payment.referral.payment.policy') == 'all'): ?> <?php echo e(__('of all their purchases')); ?> <?php else: ?> <?php echo e(__('of their first purchase')); ?><?php endif; ?></span>
                    <div class="text-center mt-3 mb-2"><a href="<?php echo e(route('user.referral')); ?>" class="btn btn-primary pl-6 pr-6 fs-11" id="referral-button"> <?php echo e(__('Invite Friends')); ?></a></div>              
                </div>
            <?php endif; ?>
        </div>
    </ul>
</aside>

<div class="modal fade" id="creditsModel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
          <div class="modal-content">
            <div class="modal-header">
                <h6 class="text-center font-weight-bold fs-16"> <?php echo e(__('Credits on')); ?> <?php echo e(config('app.name')); ?></h6>	
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pl-5 pr-5">
                
                <h6 class="font-weight-semibold mb-2 mt-3"><?php echo e(__('Unlock your creativity with')); ?> <?php echo e(config('app.name')); ?> <?php echo e(__('credits')); ?></h6>
                <p class="text-muted"><?php echo e(__('Maximize your content creation with')); ?> <?php echo e(config('app.name')); ?>. <?php echo e(__('Each credit unlocks powerful AI tools and features designed to enhance your content creation.')); ?></p>
                
                <div class="d-flex justify-content-between mt-3">
                    <div class="font-weight-bold fs-12"><?php echo e(__('AI Chats/Templates')); ?></div>
                    <div class="font-weight-bold fs-12"><?php echo e(__('Credits')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI GPT 4o')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableGPT4oWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(\App\Services\HelperService::userAvailableGPT4oWords()); ?>  <?php endif; ?><?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI GPT 4o Mini')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableGPT4oMiniWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(\App\Services\HelperService::userAvailableGPT4oMiniWords()); ?>  <?php endif; ?><?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI GPT 4')); ?></div>
                    <div class="text-muted fs-10"><span><?php if(\App\Services\HelperService::userAvailableGPT4Words() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(\App\Services\HelperService::userAvailableGPT4Words()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></span></div>
                </div>                
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI GPT 4 Turbo')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableGPT4TWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableGPT4TWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI GPT 3.5 Turbo')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('OpenAI Fine Tune')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableFineTuneWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableFineTuneWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Anthropic Claude 3 Opus')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableClaudeOpusWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableClaudeOpusWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Anthropic Claude 3.5 Sonnet')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableClaudeSonnetWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableClaudeSonnetWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Anthropic Claude 3 Haiku')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableClaudeHaikuWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableClaudeHaikuWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Google Gemini Pro')); ?></div>
                    <div class="text-muted fs-10"><?php if(\App\Services\HelperService::userAvailableGeminiProWords() == -1): ?> <?php echo e(__('Unlimited')); ?> <?php else: ?> <?php echo e(App\Services\HelperService::userAvailableGeminiProWords()); ?> <?php endif; ?> <?php echo e(__('Words')); ?></div>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <div class="font-weight-bold fs-12"><?php echo e(__('AI Image')); ?></div>
                    <div class="font-weight-bold fs-12"><?php echo e(__('Credits')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Dalle')); ?></div>
                    <div class="text-muted fs-10"><?php echo e(\App\Services\HelperService::userAvailableDEImages()); ?> <?php echo e(__('Images')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('Stable Diffusion')); ?></div>
                    <div class="text-muted fs-10"><?php echo e(\App\Services\HelperService::userAvailableSDImages()); ?> <?php echo e(__('Images')); ?></div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <div class="font-weight-bold fs-12"><?php echo e(__('Extra')); ?></div>
                    <div class="font-weight-bold fs-12"><?php echo e(__('Credits')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('AI Voiceover')); ?></div>
                    <div class="text-muted fs-10"><?php echo e(App\Services\HelperService::getTotalCharacters()); ?> <?php echo e(__('Characters')); ?></div>
                </div>
                <hr class="mt-2 mb-2">
                <div class="d-flex justify-content-between">
                    <div class="text-muted fs-10"><?php echo e(__('AI Speech to Text')); ?></div>
                    <div class="text-muted fs-10"><?php echo e(App\Services\HelperService::getTotalMinutes()); ?> <?php echo e(__('Minutes')); ?></div>
                </div>
               
                <div class="text-center mt-4"><a href="<?php echo e(route('user.plans')); ?>" class="btn btn-primary pl-6 pr-6 fs-11" style="text-transform: none"> <i class="fa-solid fa-bolt text-yellow mr-2"></i> <?php echo e(__('Upgrade Now')); ?></a></div> 
            </div>
          </div>
    </div>
</div>
<!-- END SIDE MENU BAR --><?php /**PATH C:\xampp\htdocs\a2chub project full source code backup\public_html\resources\views/layouts/nav-aside.blade.php ENDPATH**/ ?>