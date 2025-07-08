<h2>Новая задача создана</h2>

<p><strong>Название:</strong> {{ $task->title }}</p>
<p><strong>Описание:</strong> {{ $task->description }}</p>
<p><strong>Автор:</strong> {{ $task->creator->name ?? 'N/A' }}</p>
<p><strong>Назначено на:</strong> {{ $task->assignee->name ?? 'Не назначено' }}</p>
<p><strong>Статус:</strong> {{ $task->status }}</p>
