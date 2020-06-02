<table class="table table-striped table-bordered ">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="text-center">Title</th>
        <th scope="col" class="text-center">Question</th>
        <th scope="col" class="text-center">Correct Answers</th>
        <th scope="col" class="text-center">User Answers</th>
    </tr>
    </thead>
    <tbody id="addElements">
    <?php foreach ($results['questions'] as $index => $question) { ?>
        <tr>
            <td><?= $question['question']['question_title'] ?></td>
            <td><?= $question['question']['question'] ?></td>
            <td>
                <?php foreach ($question['correctlyAnswers'] as $answerId => $answer) { ?>
                    <?= $answer ?>
                    <br>
                <?php } ?>
            </td>
            <td>
                <?php foreach ($question['userAnswers'] as $answerId => $answer) { ?>
                    <?php if ($question['correct']) { ?>
                        <span class="label label-success"><?= $answer ?></span>
                    <?php } else { ?>
                        <span class="label label-danger"><?= $answer ?></span>
                    <?php } ?>
                    <br>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="3">Answers</td>
        <td class="text-center"><?= $results['countCorrectlyUserAnswers'] ?>
            / <?= $results['countQuestions'] ?></td>
    </tr>
    <tr>
        <td colspan="3">Points</td>
        <td class="text-center"><?= $results['points'] ?>%</td>
    </tr>
    </tbody>
</table>
