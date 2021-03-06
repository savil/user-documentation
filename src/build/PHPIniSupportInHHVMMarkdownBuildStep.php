<?hh // strict

namespace HHVM\UserDocumentation;

require_once(BuildPaths::PHP_INI_SUPPORT_IN_HHVM);

final class PHPIniSupportInHHVMMarkdownBuildStep extends BuildStep {
  public function buildAll(): void {
    Log::i("\nPHPIniSupportInHHVMMarkdownBuild");
    $settings = PHPIniSupportInHHVM::getData();
    if (!is_dir(BuildPaths::GUIDES_GENERATED_MARKDOWN)) {
      mkdir(
        BuildPaths::GUIDES_GENERATED_MARKDOWN,
        /* mode = */ 0755,
        /* recursive = */ true
      );
    }
    $md = $this->getMarkdown($settings);
    file_put_contents(
      BuildPaths::GUIDES_GENERATED_MARKDOWN . '/php_ini_support_in_hhvm.md',
      $md
    );
  }

  private function getMarkdown(array<string, string> $settings): string {
    $md = '';
    $cols = 5;
    // Create blank table headers
    $md .= str_repeat(' Option |', $cols);
    $md =  rtrim($md, '|');
    $md .= "\n";
    $md .= str_repeat('------ |', $cols);
    $md =  rtrim($md, '|');
    $md .= "\n";
    // Add settings to table
    $col = 0;
    foreach ($settings as $setting => $url) {
      if ($col === $cols) {
        $md =  rtrim($md, '|');
        $md .= "\n";
        $col = 0;
      }
      $md .= '[' . $setting . '](' . $url . ') |';
      $col++;
    }

    return $md;
  }
}
