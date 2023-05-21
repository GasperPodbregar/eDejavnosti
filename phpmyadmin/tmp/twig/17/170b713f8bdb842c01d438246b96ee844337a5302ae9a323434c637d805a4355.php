<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* toggle_button.twig */
class __TwigTemplate_de9e61430fb65c0e1604ec74a716d1fd32f3ce92f55ec88dcabd3d4263f6de97 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class='wrapper toggleAjax hide'>
    <div class='toggleButton'>
        <div title=\"";
        // line 3
        echo _gettext("Click to toggle");
        echo "\" class='container ";
        echo twig_escape_filter($this->env, ($context["state"] ?? null), "html", null, true);
        echo "'>
            <img src=\"";
        // line 4
        echo twig_escape_filter($this->env, ($context["pma_theme_image"] ?? null), "html", null, true);
        echo "toggle-";
        echo twig_escape_filter($this->env, ($context["text_dir"] ?? null), "html", null, true);
        echo ".png\">
            <table class='nospacing nopadding'>
                <tbody>
                    <tr>
                        <td class='toggleOn'>
                            <span class='hide'>";
        // line 9
        echo ($context["link_on"] ?? null);
        echo "</span>
                            <div>";
        // line 10
        echo twig_escape_filter($this->env, ($context["toggle_on"] ?? null), "html", null, true);
        echo "</div>
                        </td>
                        <td><div>&nbsp;</div></td>
                        <td class='toggleOff'>
                            <span class='hide'>";
        // line 14
        echo ($context["link_off"] ?? null);
        echo "</span>
                            <div>";
        // line 15
        echo twig_escape_filter($this->env, ($context["toggle_off"] ?? null), "html", null, true);
        echo "</div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <span class='hide callback'>";
        // line 20
        echo twig_escape_filter($this->env, ($context["callback"] ?? null), "html", null, true);
        echo "</span>
            <span class='hide text_direction'>";
        // line 21
        echo twig_escape_filter($this->env, ($context["text_dir"] ?? null), "html", null, true);
        echo "</span>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "toggle_button.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 21,  80 => 20,  72 => 15,  68 => 14,  61 => 10,  57 => 9,  47 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "toggle_button.twig", "C:\\Users\\Nik\\Desktop\\zaklucna\\phpmyadmin\\templates\\toggle_button.twig");
    }
}
