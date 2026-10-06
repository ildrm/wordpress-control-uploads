<?php
declare(strict_types=1);
namespace ContentFirewall\Security;
final class SvgSanitizer
{
    private const ELEMENTS = ['svg', 'g', 'path', 'rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'text', 'tspan', 'title', 'desc', 'defs', 'linearGradient', 'radialGradient', 'stop', 'clipPath'];
    private const ATTRS = ['id', 'viewBox', 'width', 'height', 'x', 'y', 'x1', 'x2', 'y1', 'y2', 'cx', 'cy', 'r', 'rx', 'ry', 'd', 'points', 'fill', 'fill-opacity', 'stroke', 'stroke-width', 'stroke-opacity', 'opacity', 'transform', 'offset', 'stop-color', 'stop-opacity', 'gradientUnits', 'gradientTransform', 'font-size', 'text-anchor'];
    public function sanitize(string $xml): string
    {
        if (strlen($xml) > 1048576 || preg_match('/<!DOCTYPE|<!ENTITY/i', $xml)) { throw new \RuntimeException('SECURITY.SVG_ENTITY'); }
        $previous = libxml_use_internal_errors(true);
        try {
            $doc = new \DOMDocument();
            if (!$doc->loadXML($xml, LIBXML_NONET) || !$doc->documentElement || $doc->documentElement->localName !== 'svg' || $doc->documentElement->namespaceURI !== 'http://www.w3.org/2000/svg') { throw new \RuntimeException('SECURITY.SVG_PARSE'); }
            $nodes = iterator_to_array($doc->getElementsByTagName('*'));
            if (count($nodes) > 5000) { throw new \RuntimeException('SECURITY.SVG_NODES'); }
            foreach ($nodes as $node) {
                if (!in_array($node->localName, self::ELEMENTS, true) || $node->namespaceURI !== 'http://www.w3.org/2000/svg') { $node->parentNode?->removeChild($node); continue; }
                foreach (iterator_to_array($node->attributes) as $attr) {
                    if ($attr->namespaceURI !== null || !in_array($attr->name, self::ATTRS, true) || strlen($attr->value) > 32768 || preg_match('/url\s*\(|javascript|data:|https?:|[<>]/i', $attr->value)) { $node->removeAttributeNode($attr); }
                }
            }
            // Remove processing instructions, comments, and namespace declarations from reconstructed tree.
            $safe = new \DOMDocument('1.0', 'UTF-8');
            $copy = function (\DOMNode $node, \DOMNode $target) use (&$copy, $safe): void {
                foreach ($node->childNodes as $child) {
                    if ($child instanceof \DOMElement) {
                        $element = $safe->createElementNS('http://www.w3.org/2000/svg', $child->localName);
                        foreach ($child->attributes as $attr) { if (in_array($attr->name, self::ATTRS, true) && $attr->namespaceURI === null) { $element->setAttribute($attr->name, $attr->value); } }
                        $target->appendChild($element); $copy($child, $element);
                    } elseif ($child instanceof \DOMText) { $target->appendChild($safe->createTextNode($child->data)); }
                }
            };
            $copy($doc, $safe); $result = $safe->saveXML($safe->documentElement);
            if ($result === false) { throw new \RuntimeException('SECURITY.SVG_OUTPUT'); }
            return $result;
        } finally { libxml_clear_errors(); libxml_use_internal_errors($previous); }
    }
}
