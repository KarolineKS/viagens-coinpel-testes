<div class="table-responsive">
    <table class="table table-custom">
        @if(isset($head))
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        @endif

        @if(isset($body))
        <tbody>
            {{ $body }}
        </tbody>
        @endif
    </table>
</div>