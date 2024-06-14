<div class="judgesContainer">

    @include('facilitator.singleEvent.judges.byCategory.preliminary')
    @include('facilitator.singleEvent.judges.byCategory.final')

</div>

<style>
    .judgesContainer{
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 90%;
        margin: auto;
    }
</style>
