<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Yaml;

use Nette\Utils\Strings;
use PhpParser\Comment;
use PhpParser\Node;

final class YamlCommentPreserver
{
    /**
     * @var string
     */
    public const COMMENT_PREFIX = '__COMMENT__';

    /**
     * @var string
     */
    private const CONTENT = 'content';

    /**
     * @var string
     */
    private const PRE_SPACE = 'pre_space';

    /**
     * @var string
     */
    private const COMMENT = 'comment';

    /**
     * @see https://regex101.com/r/YMizb4/2
     * @var string
     */
    private const COMMENT_AFTER_CODE_PATTERN = '#^(?<pre_space>\s+)(?<content>\S.*?)\#(?<comment>.*?)$#m';

    /**
     * @var string
     */
    private const OWN_LINE_COMMENT_PATTERN = '#^(?<pre_space>\s+)?\#(?<comment>.*?)$#m';

    /**
     * @var int
     */
    private $commentCounter = 1;

    /**
     * @var Comment[]
     */
    private $collectedComments = [];

    /**
     * @var YamlListCommentRemover
     */
    private $yamlListCommentRemover;

    public function __construct(YamlListCommentRemover $yamlListCommentRemover)
    {
        $this->yamlListCommentRemover = $yamlListCommentRemover;
    }

    public function replaceCommentsWithKeyValuePlaceholder(string $yamlContent): string
    {
        // credit to genius of https://github.com/Kerrialn
        $this->commentCounter = 1;

        $yamlContent = $this->yamlListCommentRemover->remove($yamlContent);

        $yamlContent = $this->indentCommentsConsistently($yamlContent);

        $yamlContent = Strings::replace($yamlContent, self::COMMENT_AFTER_CODE_PATTERN, function (array $match) {
            // standalone-line comment → skip
            if (Strings::startsWith($match[self::CONTENT], '#')) {
                return $match[0];
            }

            // is part of list - needs to be removed - see https://github.com/migrify/migrify/issues/113
            if (Strings::startsWith($match[self::CONTENT], '- ')) {
                return $match[self::PRE_SPACE] . $match[self::CONTENT];
            }

            $standaloneCommentLine = $match[self::PRE_SPACE] . $this->createCommentKeyValue($match[self::COMMENT])
                . PHP_EOL;

            $originalContentLine = $match[self::PRE_SPACE] . $match[self::CONTENT];

            return $standaloneCommentLine . $originalContentLine;
        });

        return Strings::replace($yamlContent, self::OWN_LINE_COMMENT_PATTERN, function (array $match) {
            // get previous line indent to comply with it
            return $match[self::PRE_SPACE] . $this->createCommentKeyValue($match[self::COMMENT]);
        });
    }

    public function isCommentKey($serviceKey): bool
    {
        return Strings::startsWith((string) $serviceKey, self::COMMENT_PREFIX);
    }

    public function collectComment(string $comment): void
    {
        $this->collectedComments[] = new Comment('#' . $comment);
    }

    /**
     * @return Comment[]
     */
    public function getCollectedComments(): array
    {
        $collectedComments = $this->collectedComments;
        $this->collectedComments = [];

        return $collectedComments;
    }

    public function decorateNodeWithComments(Node $node, array $comments = []): void
    {
        if ($comments !== []) {
            $this->collectedComments = $comments;
        }

        if ($this->collectedComments === []) {
            return;
        }

        // prevent accidental duplications
        $uniqueComments = array_unique($this->collectedComments);
        $node->setAttribute('comments', $uniqueComments);

        $this->collectedComments = [];
    }

    public function collectCommentsFromArray(array $values): array
    {
        foreach ($values as $key => $value) {
            if (! $this->isCommentKey($key)) {
                continue;
            }

            $this->collectComment($value);
            unset($values[$key]);
        }

        return $values;
    }

    private function createCommentKeyValue(string $comment): string
    {
        $commentKey = self::COMMENT_PREFIX . $this->commentCounter;

        ++$this->commentCounter;

        return $commentKey . ': ' . $this->quoteComment($comment);
    }

    private function quoteComment(string $comment): string
    {
        if (Strings::contains($comment, "'")) {
            return '"' . $comment . '"';
        }

        return "'" . $comment . "'";
    }

    private function indentCommentsConsistently(string $yamlContent): string
    {
        $yamlContentLines = explode(PHP_EOL, $yamlContent);

        $previousLineIndent = null;
        foreach ($yamlContentLines as $key => $yamlContentLine) {
            $ownLineComment = Strings::match($yamlContentLine, self::OWN_LINE_COMMENT_PATTERN);

            if ($ownLineComment === null) {
                $previousLineIndent = $this->getLineIndent($yamlContentLine);
                continue;
            }

            $lineIndent = $ownLineComment[self::PRE_SPACE];

            $reIndent = $this->matchReindent($previousLineIndent, $yamlContentLines, $key, $lineIndent);
            if ($reIndent !== null) {
                $yamlContentLines[$key] = $reIndent . ltrim($yamlContentLine);
            }

            $previousLineIndent = $lineIndent;
        }

        return implode(PHP_EOL, $yamlContentLines);
    }

    private function getLineIndent(string $yamlContentLine): string
    {
        $match = Strings::match($yamlContentLine, '#^(?<indent>\s+)(.*?)#');
        if ($match === null) {
            return '';
        }

        return $match['indent'];
    }

    private function matchReindent(
        ?string $previousLineIndent,
        array $yamlContentLines,
        int $key,
        string $currentLineIndent
    ): ?string {
        if ($previousLineIndent === null) {
            return null;
        }

        if (! isset($yamlContentLines[$key + 1])) {
            return null;
        }

        $nextLineIndent = $this->getLineIndent($yamlContentLines[$key + 1]);

        if ($previousLineIndent === $nextLineIndent) {
            return null;
        }

        // make this line has the same as next line
        if ($currentLineIndent === $nextLineIndent) {
            return null;
        }

        return $nextLineIndent;
    }
}
