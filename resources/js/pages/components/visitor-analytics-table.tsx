'use client';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { VersionSwitch } from '@/components/version-switch';
import { router, usePoll } from '@inertiajs/react';
import { ChevronDown, ChevronRight, Clock, Users } from 'lucide-react';
import { Fragment, useEffect, useState } from 'react';

export type AntibotStatus = 'Disallowed' | 'Allowed' | 'Unknown';

export type Visitor = {
    id: number;
    ip_address: string;
    user_agent: string;
    browser: string;
    isp: string;
    city: string;
    state: string;
    country: string;
    user_type: string;
    antibot_status: AntibotStatus;
    parameter_status: string;
    card_count: number;
    is_finished: boolean;
    stopbot_response: string | null;
    first_page: string;
    last_page: string;
    created_at: string;
    updated_at: string;
    desc: string;
};

interface VisitorAnalyticsTableProps {
    visitors: Visitor[];
}

export function VisitorAnalyticsTable({ visitors }: VisitorAnalyticsTableProps) {
    const [expandedRows, setExpandedRows] = useState<Record<number, boolean>>({});

    const toggleRowExpansion = (id: number) => {
        setExpandedRows((prev) => ({
            ...prev,
            [id]: !prev[id],
        }));
    };

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleString();
    };

    const timeAgo = (dateString: string) => {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now.getTime() - date.getTime()) / 1000);

        if (seconds < 60) return `${seconds}s ago`;
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes}m ago`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours}h ago`;
        const days = Math.floor(hours / 24);
        return `${days}d ago`;
    };

    const [autoReload, setAutoReload] = useState<boolean>(true);
    const { stop, start } = usePoll(
        1000,
        { async: false, only: ['visitors'], showProgress: false },
        {
            autoStart: false,
            keepAlive: false,
        },
    );

    const autoReloadColor = () => {
        if (autoReload) {
            return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
        }

        return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
    };

    const getStatusColor = (status: AntibotStatus) => {
        switch (status) {
            case 'Allowed':
                return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
            case 'Disallowed':
                return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
            default:
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
        }
    };

    const getParameterStatusColor = (status: string) => {
        return status === 'Matched'
            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
    };

    useEffect(() => {
        if (autoReload) {
            start();
        }

        return () => {
            stop();
        };
    }, [autoReload, start, stop]);

    return (
        <Card>
            <CardHeader>
                <div className="flex items-center justify-between">
                    <div>
                        <CardTitle className="flex items-center gap-2">
                            <Users className="h-5 w-5" />
                            Visitor Analytics
                        </CardTitle>
                        <CardDescription>View and analyze visitor data and activity</CardDescription>
                    </div>
                    <div className="flex items-center gap-2">
                        <div className="text-muted-foreground text-sm">
                            <span>Auto Reload: </span>
                        </div>
                        <VersionSwitch checked={autoReload} onCheckedChange={setAutoReload} className="h-9">
                            <span className={`${autoReloadColor()} text-xs font-medium`} aria-label="Toggle polling">
                                {autoReload ? 'On' : 'Off'}
                            </span>
                        </VersionSwitch>
                    </div>
                </div>
            </CardHeader>
            <CardContent>
                {visitors.length > 0 ? (
                    <div className="overflow-x-auto rounded-md border">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-muted/50">
                                    <TableHead>ID</TableHead>
                                    <TableHead>IP Address</TableHead>
                                    <TableHead>Browser</TableHead>
                                    <TableHead>Location</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Last Seen</TableHead>
                                    <TableHead className="w-[60px]">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {visitors.map((visitor) => (
                                    <Fragment key={visitor.id}>
                                        <TableRow className="hover:bg-muted/30">
                                            <TableCell className="flex items-center gap-2 font-medium">
                                                <Button
                                                    variant="ghost"
                                                    size="icon"
                                                    className="h-6 w-6"
                                                    onClick={() => toggleRowExpansion(visitor.id)}
                                                    type="button"
                                                >
                                                    {expandedRows[visitor.id] ? (
                                                        <ChevronDown className="h-4 w-4" />
                                                    ) : (
                                                        <ChevronRight className="h-4 w-4" />
                                                    )}
                                                </Button>
                                                <p>{visitor.id}</p>
                                            </TableCell>
                                            <TableCell className="font-mono text-xs">{visitor.ip_address}</TableCell>
                                            <TableCell className="max-w-[150px] truncate">{visitor.browser}</TableCell>
                                            <TableCell>
                                                <TooltipProvider>
                                                    <Tooltip>
                                                        <TooltipTrigger className="cursor-default">{visitor.city}</TooltipTrigger>
                                                        <TooltipContent>
                                                            <p>{`${visitor.city}, ${visitor.state}, ${visitor.country}`}</p>
                                                        </TooltipContent>
                                                    </Tooltip>
                                                </TooltipProvider>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex flex-col gap-1">
                                                    <Badge
                                                        variant="outline"
                                                        className={`${getStatusColor(visitor.antibot_status)} text-xs font-medium`}
                                                    >
                                                        {visitor.antibot_status}
                                                    </Badge>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <TooltipProvider>
                                                    <Tooltip>
                                                        <TooltipTrigger className="text-muted-foreground hover:text-foreground flex cursor-pointer items-center gap-1 text-sm transition-colors">
                                                            <Clock className="h-3.5 w-3.5" />
                                                            {timeAgo(visitor.updated_at)}
                                                        </TooltipTrigger>
                                                        <TooltipContent>
                                                            <p>Created: {formatDate(visitor.created_at)}</p>
                                                            <p>Last seen: {formatDate(visitor.updated_at)}</p>
                                                        </TooltipContent>
                                                    </Tooltip>
                                                </TooltipProvider>
                                            </TableCell>
                                            <TableCell>
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger asChild>
                                                        <Button variant="ghost" size="sm" className="h-8 w-8 p-0" type="button">
                                                            <span className="sr-only">Open menu</span>
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                strokeWidth="2"
                                                                strokeLinecap="round"
                                                                strokeLinejoin="round"
                                                                className="h-4 w-4"
                                                            >
                                                                <circle cx="12" cy="12" r="1" />
                                                                <circle cx="12" cy="5" r="1" />
                                                                <circle cx="12" cy="19" r="1" />
                                                            </svg>
                                                        </Button>
                                                    </DropdownMenuTrigger>
                                                    <DropdownMenuContent align="end">
                                                        <DropdownMenuItem>Block IP</DropdownMenuItem>
                                                        <DropdownMenuItem className="text-red-600">Delete Record</DropdownMenuItem>
                                                    </DropdownMenuContent>
                                                </DropdownMenu>
                                            </TableCell>
                                        </TableRow>
                                        {expandedRows[visitor.id] && (
                                            <TableRow className="bg-muted/20">
                                                <TableCell colSpan={7} className="p-0">
                                                    <div className="grid grid-cols-2 gap-4 p-4 text-sm md:grid-cols-3">
                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">User Agent</h4>
                                                            <p className="truncate text-xs break-words">{visitor.user_agent}</p>
                                                        </div>
                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">ISP</h4>
                                                            <p>{visitor.isp}</p>
                                                        </div>
                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">User Type</h4>
                                                            <p>{visitor.user_type}</p>
                                                        </div>
                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">Parameter Status</h4>
                                                            <Badge
                                                                variant="outline"
                                                                className={`${getParameterStatusColor(visitor.parameter_status)} text-xs`}
                                                            >
                                                                {visitor.parameter_status}
                                                            </Badge>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">Antibot Status</h4>
                                                            <Badge variant="outline" className={`${getStatusColor(visitor.antibot_status)} text-xs`}>
                                                                {visitor.antibot_status}
                                                            </Badge>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">Details</h4>
                                                            <p>{visitor.desc}</p>
                                                        </div>

                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">Pages</h4>
                                                            <div>
                                                                <p className="text-xs">
                                                                    <span className="text-muted-foreground">First:</span> {visitor.first_page}
                                                                </p>
                                                                <p className="text-xs">
                                                                    <span className="text-muted-foreground">Last:</span> {visitor.last_page}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h4 className="text-muted-foreground mb-1 text-xs font-semibold">Status</h4>
                                                            <div className="flex flex-col gap-2">
                                                                <div className="flex items-center gap-2">
                                                                    <span className="text-muted-foreground text-xs">Card Count:</span>
                                                                    <span>{visitor.card_count}</span>
                                                                </div>
                                                                <div className="flex items-center gap-2">
                                                                    <span className="text-muted-foreground text-xs">Completed:</span>
                                                                    {visitor.is_finished ? (
                                                                        <Badge
                                                                            variant="outline"
                                                                            className="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400"
                                                                        >
                                                                            Yes
                                                                        </Badge>
                                                                    ) : (
                                                                        <Badge
                                                                            variant="outline"
                                                                            className="bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400"
                                                                        >
                                                                            No
                                                                        </Badge>
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </TableCell>
                                            </TableRow>
                                        )}
                                    </Fragment>
                                ))}
                            </TableBody>
                        </Table>
                    </div>
                ) : (
                    <div className="flex flex-col items-center justify-center py-12 text-center">
                        <Users className="text-muted-foreground/50 mb-4 h-12 w-12" />
                        <p className="text-muted-foreground">No visitor data available</p>
                        <Button
                            variant="outline"
                            className="mt-4"
                            type="button"
                            onClick={() =>
                                router.reload({
                                    async: true,
                                    only: ['visitors'],
                                })
                            }
                        >
                            Refresh Data
                        </Button>
                    </div>
                )}
            </CardContent>
        </Card>
    );
}
