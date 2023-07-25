
@foreach ($chart->plugins as $plugin)
    @include($chart->pluginsViews[$plugin])
@endforeach

<script {!! $chart->displayScriptAttributes() !!}>
    var ctvChart = document.getElementById('{{ $chart->id }}').getContext('2d');
    function {{ $chart->id }}_create(data) {
        {{ $chart->id }}_rendered = true;
        document.getElementById("{{ $chart->id }}_loader").style.display = 'none';
        document.getElementById("{{ $chart->id }}").style.display = 'block';
        var optionsJson = {!! $chart->formatOptions(true) !!};
        @if($chart->costumAnchor)
            optionsJson.plugins.datalabels.anchor = function(context) {
                var index = context.dataIndex;
                var value = context.dataset.data[index];
                return value < {{ $chart->minConditionalAnchor }} ? '{{ $chart->positionAnchor[0] }}' : '{{ $chart->positionAnchor[1] }}';
            }
            optionsJson.plugins.datalabels.color = function(context) {
                        var index = context.dataIndex;
                var value = context.dataset.data[index];
                return value < {{ $chart->minConditionalAnchor }} ? '{{ $chart->colorAnchor[0] }}' : '{{ $chart->colorAnchor[1] }}';
            },
        @endif
        window.{{ $chart->id }} = new Chart(document.getElementById("{{ $chart->id }}").getContext("2d"), {
            type: {!! $chart->type ? "'{$chart->type}'" : 'data[0].type' !!},
            data: {
                labels: {!! $chart->formatLabels() !!},
                datasets: data
            },
            options: optionsJson,
            plugins: {!! $chart->formatPlugins(true) !!}
        });
    }
    @if ($chart->api_url)
    let {{ $chart->id }}_refresh = function (url) {
        document.getElementById("{{ $chart->id }}").style.display = 'none';
        document.getElementById("{{ $chart->id }}_loader").style.display = 'flex';
        if (typeof url !== 'undefined') {
            {{ $chart->id }}_api_url = url;
        }
        fetch({{ $chart->id }}_api_url)
            .then(data => data.json())
            .then(data => {
                document.getElementById("{{ $chart->id }}_loader").style.display = 'none';
                document.getElementById("{{ $chart->id }}").style.display = 'block';
                {{ $chart->id }}.data.datasets = data;
                {{ $chart->id }}.update();
            });
    };
    @endif
@include('charts::init')

</script>
