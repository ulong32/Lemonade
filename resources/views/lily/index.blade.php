@extends('app.layout', ['page-type' => 'back-triangle', 'title' => 'リリィ一覧'])

<?php
    /**
     * @var $lilies array
     * @var $legions array
     * @var $lily array
     */
?>

@section('head')
    <script type="application/javascript">
        document.addEventListener('DOMContentLoaded',()=>{
            document.querySelectorAll('#sort-select > option').forEach((item)=>{
                if(item.attributes.value.value === "{{ $sortKey }}")
                    item.setAttribute('selected', true);
            });
            document.getElementById('sort-select').addEventListener('change',(e)=>{
                let order = e.target.value.substr(0,1);
                switch (order){
                    case 'a':
                        order = 'asc'; break;
                    case 'd':
                        order = 'desc'; break;
                    default:
                        order = false;
                }
                let sort = e.target.value.substr(2);
                let next = '{{ route('lily.index') }}?sort='+sort;
                if(order !== false) next = next.concat('&order='+order);
                location.href = next;
            });
        });
    </script>
@endsection

@section('main')
    <main>
        <div class="top-options">
            <div>
                <label>
                    ならべかえ :
                    <select id="sort-select">
                        <option value="a-name">フルネーム | 昇順</option>
                        <option value="d-name">フルネーム | 降順</option>
                        <option value="a-givenName">名前 | 昇順</option>
                        <option value="d-givenName">名前 | 降順</option>
                        <option value="a-rareSkill">レアスキル | 昇順</option>
                        <option value="d-rareSkill">レアスキル | 降順</option>
                        <option value="a-age">年齢 | 昇順</option>
                        <option value="d-age">年齢 | 降順</option>
                        <option value="a-position">ポジション | 昇順</option>
                        <option value="d-position">ポジション | 降順</option>
                        <option value="a-legion">レギオン | 昇順</option>
                        <option value="d-legion">レギオン | 降順</option>
                    </select>
                </label>
            </div>
            <div>
                <span class="info">リリィ登録数 : {{ count($lilies) }}</span>
            </div>
        </div>
        <div class="list three">
            @forelse($lilies as $key => $lily)
                <?php $legion = $legions[$lily['lily:legion'][0] ?? ''] ?? array(); ?>
                @include('app.button_lily',['key' => $key, 'lily' => $lily, 'legion' => $legion])
            @empty
                <p style="text-align: center; color: darkred; margin: 3em auto">該当するデータがありません</p>
            @endforelse
            @if((count($lilies) % 3) != 0)
                <div style="width: 32%; margin-left: 6px"></div>
            @endif
        </div>
    </main>
@endsection
