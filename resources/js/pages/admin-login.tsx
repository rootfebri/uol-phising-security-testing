import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { useForm } from '@inertiajs/react';

/* eslint-disable @typescript-eslint/ban-ts-comment */
export default function () {
    const { post, errors, data, setData, processing } = useForm({
        username: '',
        password: '',
        remember: false as boolean,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('admin.login.store'), {
            onFinish: () => setData('password', ''),
        });
    };

    return (
        <div className="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
            <div className="w-full max-w-sm">
                <Card>
                    <CardContent>
                        <form onSubmit={handleSubmit}>
                            <div className="grid gap-6">
                                <div className="grid gap-6">
                                    <div className="grid gap-2">
                                        <Label htmlFor="username">Username</Label>
                                        <Input
                                            id="username"
                                            type="text"
                                            placeholder="..."
                                            value={data.username}
                                            required
                                            onChange={({ target: { value } }) => setData('username', value)}
                                        />
                                        <InputError message={errors.username} />
                                    </div>
                                    <div className="grid gap-2">
                                        <div className="flex items-center">
                                            <Label htmlFor="password">Password</Label>
                                        </div>
                                        <Input
                                            id="password"
                                            type="password"
                                            required
                                            value={data.password}
                                            onChange={({ target: { value } }) => setData('password', value)}
                                        />
                                        <InputError message={errors.password} />
                                    </div>
                                    <div className="grid gap-2">
                                        <div className="flex items-center">
                                            <Label htmlFor="remember">Remember</Label>
                                        </div>
                                        <Switch id="remember" checked={data.remember} onCheckedChange={(checked) => setData('remember', checked)} />
                                        <InputError message={errors.remember} />
                                        {/*// @ts-expect-error */}
                                        <InputError message={errors[0]} />
                                    </div>

                                    <Button type="submit" className="w-full" disabled={processing}>
                                        Login
                                    </Button>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    );
}
