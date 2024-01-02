<ol class="px-2">
    <li>
        <span>Texnik tavsiya bergan gaz ta&#8217;minoti nomi, sanasi raqami va iste&#8217;molchi nomi, manzili va faoliyat turi: &#8220;{{$recommendation->organ->name}}&#8221; filialining</span>
        <span style="text-transform: lowercase">{{extendedDate($recommendation->created_at, true)}}dagi</span> {{$recommendation->id}}-sonli texnik tavsiyanomasiga asosan,
        <span>{{$recommendation->address}}da joylashgan, {{$proposition->applicant->name}}ga qarashli <span style="text-transform: lowercase">{{$proposition->buildType()}}</span> binosini gazlashtirish.</span>
        <br>
    </li>
    <li>
        <span>Gaz quvuriga ulanish joyi, harakatdagi yer osti/usti, <u class="text-lowercase">@lang("organ.recommendation.$recommendation->pipe_type")</u> gaz tarmog&#8216;iga,</span>
        <span>ulanish nuqtasiga bo&#8216;lgan masofa: {{$recommendation->length}} p/m, D-{{$recommendation->pipe_one}} mm,</span>
        <span>o&#8216;rt. qishgi - {{$recommendation->pressure_win}} kgc/cm<sup>2</sup>, o&#8216;rt. yozgi - {{$recommendation->pressure_sum}} kgc/cm<sup>2</sup>, <b><u>{{$recommendation->grc}}</u></b>-GFT</span>
    </li>
    <li>Soatlik, yillik gaz iste&#8217;moli sarfi: 0 m<sup>3</sup>/soat. {{$recommendation->consumption}} m<sup>3</sup>/yil </li>
    <li>
        <span>Gaz jihozlari:</span>
        <span class="text-bold">
        @foreach($equipments as $equip)
            <span>{{$equip->equipment}} - {{$equip->number}} dona</span>@if($loop->last).@else,@endif
        @endforeach
        </span>
    </li>
</ol>
