<?php
namespace LabKit;
// Lab 1 form, Lab 4 student_form.php. Các spec field do code cố định, không lấy từ request.
function form(string $action, string $method, array $fields, array $values = [], array $errors = [], string $button = 'Gửi'): void
{
    $method = strtoupper($method);
    if (!in_array($method, ['GET', 'POST'], true)) throw new \InvalidArgumentException('Form chỉ dùng GET/POST.');
    $multipart = false;
    foreach ($fields as $spec) if (($spec['type'] ?? 'text') === 'file') $multipart = true;
    echo '<form action="'.escape($action).'" method="'.strtolower($method).'"'.($multipart ? ' enctype="multipart/form-data"' : '').'>';
    if ($method === 'POST') echo csrfField();
    foreach ($fields as $key => $spec) {
        $type = $spec['type'] ?? 'text';
        if (!in_array($type, ['text', 'email', 'number', 'password', 'date', 'file', 'textarea', 'select'], true)) {
            throw new \InvalidArgumentException('Loại field chưa hỗ trợ.');
        }
        echo '<p><label>'.escape($spec['label'] ?? $key).' ';
        $attrs = ' name="'.escape($key).'"'.(($spec['required'] ?? false) ? ' required' : '');
        $value = $values[$key] ?? '';
        if ($type === 'textarea') echo '<textarea'.$attrs.'>'.escape($value).'</textarea>';
        elseif ($type === 'select') {
            echo '<select'.$attrs.'>';
            foreach ($spec['options'] ?? [] as $option => $label) {
                echo '<option value="'.escape($option).'"'.((string) $option === (string) $value ? ' selected' : '').'>'.escape($label).'</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="'.$type.'"'.$attrs;
            if (!in_array($type, ['password', 'file'], true)) echo ' value="'.escape($value).'"';
            foreach (['min', 'max', 'step', 'maxlength', 'accept'] as $attr) {
                if (isset($spec[$attr])) echo ' '.$attr.'="'.escape($spec[$attr]).'"';
            }
            echo '>';
        }
        echo '</label>';
        if (isset($errors[$key])) echo ' <span role="alert">'.escape($errors[$key]).'</span>';
        echo '</p>';
    }
    echo '<button>'.escape($button).'</button></form>';
}
