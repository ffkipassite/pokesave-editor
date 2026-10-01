using System.Net.Http.Json;
using System.Text.Json.Serialization;

namespace PKHeX.Web.Services;

public sealed class EditorConfig
{
    public string SiteName { get; set; } = "PokéSave Editor";
    public string HeaderText { get; set; } = "PokéSave Editor";
    public string FooterText { get; set; } = "Browser-based Pokémon save editing";
    public string LogoUrl { get; set; } = "";
    public string FaviconUrl { get; set; } = "";
    public string PrimaryColor { get; set; } = "#5b4cf6";
    public string PrimaryHoverColor { get; set; } = "#4538d2";
    public string ButtonColor { get; set; } = "#5b4cf6";
    public string ButtonHoverColor { get; set; } = "#4538d2";
    public string BackgroundColor { get; set; } = "#f5f7fb";
    public string SurfaceColor { get; set; } = "#ffffff";
    public string TextColor { get; set; } = "#111827";
    public string MutedColor { get; set; } = "#667085";
    public string BorderColor { get; set; } = "#e5e7eb";
    public bool ShowPlugins { get; set; } = true;
    public bool ShowAnalytics { get; set; } = true;
    public bool ShowSave { get; set; } = true;
    public bool ShowOpen { get; set; } = true;
    public bool ShowSource { get; set; } = false;
}

public sealed class EditorConfigService
{
    private readonly HttpClient _http;
    private bool _loaded;

    public EditorConfig Current { get; private set; } = new();

    public EditorConfigService(HttpClient http) => _http = http;

    public async Task LoadAsync()
    {
        if (_loaded) return;
        try
        {
            var config = await _http.GetFromJsonAsync<EditorConfig>("admin/api/config.php");
            if (config is not null) Current = config;
        }
        catch
        {
            // Keep safe built-in defaults if the optional PHP admin backend is unavailable.
        }
        _loaded = true;
    }
}
