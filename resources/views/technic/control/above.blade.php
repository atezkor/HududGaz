<ol class="px-2">
    <li>
        Texnik tavsiya bergan gaz ta&#8217;minoti nomi, sanasi raqami va iste&#8217;molchi nomi, manzili va faoliyat turi: &#8220;{{$recommendation->org->org_name}}&#8221; filialining
        <span style="text-transform: lowercase">{{dateFull($recommendation->created_at, true)}}dagi</span> {{$recommendation->id}}-sonli texnik tavsiyanomasiga asosan, {{$recommendation->address}}da joylashgan,
        {{$proposition->applicant->full_name ?? $proposition->applicant->legal_name}}ga qarashli noturar binosini gazlashtirish.
        <br>
    </li>
    <li>
        Gaz quvuriga ulanish joyi, harakatdagi yer osti/usti, <u>past</u> bosimli gaz tarmog&#8216;iga,
        ulanish nuqtasiga bo&#8216;lgan masofa: {{$recommendation->length}} p/m, D-{{$recommendation->pipe1}} mm,
        o&#8216;rt. qishgi - {{$recommendation->pressure_win}} kgc/cm<sup>2</sup>, o&#8216;rt. yozgi - {{$recommendation->pressure_sum}} kgc/cm<sup>2</sup>, <b><u>Tuman</u></b> - GTS
    </li>
    <li>Soatlik, yillik gaz iste&#8217;moli sarfi: {{$recommendation->consumption}} nm<sup>3</sup>/soat. (5441) nm<sup>3</sup>/yil </li>
    <li>
        <span>Gaz jihozlari:</span>
        <span class="text-bold">
        @foreach($equipments as $equip)
            <span>{{$equip->equipment}} - {{$equip->number}} dona</span>@if($loop->last).@else,@endif
        @endforeach
        </span>
    </li>
</ol>
