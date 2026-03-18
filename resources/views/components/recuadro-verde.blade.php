@php
    use App\Helpers\UserInfoHelper;
    $userInfo = UserInfoHelper::getCurrentUserInfo();
@endphp

@if($userInfo)
<div style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); 
            border-left: 5px solid #2e7d32; 
            border-radius: 12px; 
            padding: 16px 20px; 
            margin: 20px 0; 
            box-shadow: 0 4px 12px rgba(0,40,0,0.1);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 
Roboto, sans-serif;">
    
    <div style="display: flex; align-items: center; gap: 20px;">
        <!-- Avatar -->
        <div style="position: relative;">
            @if($userInfo['foto_url'])
                <img src="{{ $userInfo['foto_url'] }}" 
                     alt="Avatar"
                     style="width: 64px; 
                            height: 64px; 
                            border-radius: 50%; 
                            object-fit: cover; 
                            border: 3px solid #2e7d32;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @else
                <div style="width: 64px; 
                            height: 64px; 
                            border-radius: 50%; 
                            background: linear-gradient(135deg, #2e7d32, 
#4caf50);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border: 3px solid #fff;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <span style="color: white; font-size: 28px; 
font-weight: 600;">
                        {{ $userInfo['inicial'] }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Información -->
        <div style="flex: 1;">
            <div style="display: flex; justify-content: space-between; 
align-items: center;">
                <div>
                    <h3 style="margin: 0; 
                               font-size: 18px; 
                               font-weight: 700; 
                               color: #1b5e20;
                               letter-spacing: -0.01em;">
                        {{ $userInfo['nombre'] }}
                    </h3>
                    <p style="margin: 6px 0 4px; 
                              color: #2e5c2e; 
                              font-size: 14px;
                              opacity: 0.9;">
                        {{ $userInfo['email'] }}
                    </p>
                </div>
                
                <!-- Badge de rol -->
                <div style="background: rgba(46, 125, 50, 0.15);
                            padding: 6px 14px;
                            border-radius: 30px;
                            border: 1px solid #2e7d32;">
                    <span style="color: #1b5e20; 
                                 font-size: 13px; 
                                 font-weight: 600;
                                 text-transform: uppercase;
                                 letter-spacing: 0.5px;">
                        {{ $userInfo['rol'] }}
                    </span>
                </div>
            </div>

            <!-- Línea decorativa -->
            <div style="margin-top: 10px;
                        height: 2px;
                        background: linear-gradient(90deg, #2e7d32, 
#a5d6a7, #e8f5e9);">
            </div>
        </div>
    </div>
</div>
@endif

