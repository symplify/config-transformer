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
    private const COMMENT_PREFIX = '__COMMENT__';

    /**
     * @see https://regex101.com/r/YMizb4/2
     * @var string
     */
    private const COMMENT_AFTER_CODE_PATTERN = '#^(?<pre_space>\s+)(?<content>\S.*?)\#(?<comment>.*?)$#m';

    /**
     * @var string
     */
    private const OWN_LINE_COMMENT_PATTERN = '#\#(?<comment>.*?)$#m';

    /**
     * @var int
     */
    private $commentCounter = 1;

    /**
     * @var string[]
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

        $yamlContent = Strings::replace($yamlContent, self::COMMENT_AFTER_CODE_PATTERN, function (array $match) {
            $standaloneCommentLine = $match['pre_space'] . $this->createCommentKeyValue($match['comment']) . PHP_EOL;
            $originalContentLine = $match['pre_space'] . $match['content'];

            return $standaloneCommentLine . $originalContentLine;
        });

        return Strings::replace($yamlContent, self::OWN_LINE_COMMENT_PATTERN, function (array $match) {
            return $this->createCommentKeyValue($match['comment']);
        });
    }

    public function isCommentKey($serviceKey): bool
    {
        return Strings::startsWith((string) $serviceKey, self::COMMENT_PREFIX);
    }

    public function collectComment(string $comment): void
    {
        $this->collectedComments[] = $comment;
    }

    public function decorateNodeWithComments(Node $node): void
    {
        if ($this->collectedComments === []) {
            return;
        }

        $comments = $this->createCommentFromStrings($this->collectedComments);
        $node->setAttribute('comments', $comments);

        $this->collectedComments = [];
    }

    private function createCommentKeyValue(string $comment): string
    {
        $commentKey = self::COMMENT_PREFIX . $this->commentCounter;
        $commentValue = "'" . trim($comment) . "'";

        ++$this->commentCounter;

        return $commentKey . ': ' . $commentValue;
    }

    /**
     * @param string[] $collectedComments
     * @return Comment[]
     */
    private function createCommentFromStrings(array $collectedComments): array
    {
        $comments = [];
        foreach ($collectedComments as $currentComment) {
            $comments[] = new Comment('# ' . $currentComment);
        }

        return $comments;
    }
}
